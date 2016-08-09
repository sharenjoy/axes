<?php

namespace Sharenjoy\Cmsharenjoy\User;

use Auth, Mail, Config, Message, Session;
use Sharenjoy\Cmsharenjoy\Core\EloquentBaseRepository;
use Sharenjoy\Cmsharenjoy\Service\Validation\ValidableInterface;

class UserRepository extends EloquentBaseRepository implements UserInterface
{
    public function __construct(User $model, ValidableInterface $validator)
    {
        $this->validator = $validator;
        $this->model     = $model;
    }

    public function create()
    {   
        try
        {
            $user = $this->model;

            $inputs = $this->getInput();
            $inputs['password'] = bcrypt($inputs['password']);

            $user->fill($inputs);
            $user->save();

            // activate user
            $activationCode = $user->getActivationCode();

            if (config('cmsharenjoy.autoActivable'))
            {
                $user->attemptActivation($activationCode);
            }
            else
            {
                $data = array(
                    'id'       => $user->id,
                    'code'     => $activationCode,
                    'username' => $user->name,
                );

                // send email
                Mail::queue('admin.emails.auth.user-activation', $data, function($message) use ($user)
                {
                    $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'))
                            ->subject('Account activation');
                    $message->to($user->email);
                });
            }
        }
        catch (\Sharenjoy\Cmsharenjoy\User\LoginRequiredException $e)
        {
            Message::error('Login field is required.');
            return false;
        }
        catch (\Sharenjoy\Cmsharenjoy\User\PasswordRequiredException $e)
        {
            Message::error('Password field is required.');
            return false;
        }
        catch (\Sharenjoy\Cmsharenjoy\User\UserExistsException $e)
        {
            Message::error('User with this login already exists.');
            return false;
        }

        return $user;
    }

    public function update($id)
    {
        try
        {
            $input = $this->getInput();

            // Find the user using the user id
            $user = $this->model->find($id);

            // Update the user details
            $user->email       = $input['email'];
            $user->name        = $input['name'];
            $user->phone       = $input['phone'];
            $user->avatar      = $input['avatar'];
            $user->description = $input['description'];

            // Update the user
            $result = $user->save();
            
            if ( ! $result)
            {
                Message::error('User information was not updated');
                return false;
            }            
        }
        catch (Sharenjoy\Cmsharenjoy\User\UserExistsException $e)
        {
            Message::error('User with this login already exists.');
            return false;
        }
        catch (Sharenjoy\Cmsharenjoy\User\UserNotFoundException $e)
        {
            Message::error('User was not found.');
            return false;
        }

        return $result;
    }

    public function activate($id, $code)
    {
        try
        {
            // Find the user using the user id
            $user = $this->model->find($id);

            // Attempt to activate the user
            if ($user->attemptActivation($code))
            {
                return ['status'=>'success', 'message'=>pick_trans('user_actived')];
            }
            else
            {
                return ['status'=>'error', 'message'=>pick_trans('error_active')];
            }
        }
        catch (\Sharenjoy\Cmsharenjoy\User\UserNotFoundException $e)
        {
            return ['status'=>'error', 'message'=>pick_trans('user_not_found')];
        }
        catch (\Sharenjoy\Cmsharenjoy\User\UserAlreadyActivatedException $e)
        {
            return ['status'=>'warning', 'message'=>pick_trans('user_already_actived')];
        }
    }

    public function remindPassword($var)
    {
        try
        {
            if (is_numeric($var))
            {
                $user = $this->model->find($var);
            }
            elseif (is_string($var))
            {
                $user = $this->model->findByLogin($var);
            }

            // Get the password reset code
            $resetCode = $user->getResetPasswordCode();

            $data = array(
                'code'      => $resetCode,
                'accessUrl' => Session::get('accessUrl'),
                'user'      => $user,
            );

            // send email
            Mail::queue('admin.emails.auth.user-reset-password', $data, function($message) use ($user)
            {
                $message->from(Config::get('mail.from.address'), Config::get('mail.from.name'))
                        ->subject(pick_trans('reset_password'));
                $message->to($user->email);
            });
        }
        catch (\Sharenjoy\Cmsharenjoy\User\UserNotFoundException $e)
        {
            return ['status'=>false, 'message'=>pick_trans('user_not_found')];
        }

        return ['status'=>true, 'message'=>pick_trans('sent_reset_code')];
    }

    public function resetPassword($input)
    {
        try
        {
            // Find the user using the user id
            $user = $this->model->findByResetPasswordCode($input['code']);

            if ($input['email'] !== $user->email)
            {
                return ['status'=>false, 'message'=>pick_trans('error_active')];
            }

            if ($input['password'] !== $input['password_confirmation'])
            {
                return ['status'=>false, 'message'=>pick_trans('password_no_match')];
            }

            // Check if the reset password code is valid
            if ($user->checkResetPasswordCode($input['code']))
            {
                // Attempt to reset the user password
                if ($user->attemptResetPassword($input['code'], $input['password']))
                {
                    Auth::logout();
                    return ['status'=>true, 'message'=>pick_trans('password_reset_success')];
                }
                else
                {
                    return ['status'=>false, 'message'=>pick_trans('password_reset_failed')];
                }
            }
            else
            {
                return Message::result(false, pick_trans('password_reset_code_invalid'));
            }
        }
        catch (\Sharenjoy\Cmsharenjoy\User\UserNotFoundException $e)
        {
            return ['status'=>false, 'message'=>pick_trans('user_not_found')];
        }
    }

    public function login($input)
    {
        $credentials = array(
            'email'    => $input['email'],
            'password' => $input['password'],
        );

        if (Auth::attempt($credentials)) {
            if (Auth::user()->activated == false) {
                Auth::logout();
                return ['status'=>false, 'message'=>pick_trans('invalid_email_password')];
            }

            return ['status'=>true, 'message'=>pick_trans('success_login')];
        } else {
            return ['status'=>false, 'message'=>pick_trans('invalid_email_password')];
        }
    }

}