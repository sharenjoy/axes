<?php namespace Sharenjoy\Cmsharenjoy\User;

use Sharenjoy\Cmsharenjoy\Core\EloquentBaseRepository;
use Sharenjoy\Cmsharenjoy\Service\Validation\ValidableInterface;
use Auth, Mail, Config, Message, Session;

class UserRepository extends EloquentBaseRepository implements UserInterface {

    public function __construct(User $model, ValidableInterface $validator)
    {
        $this->validator = $validator;
        $this->model     = $model;
    }

    public function create()
    {   
        try
        {
            $input = $this->getInput();

            $user = Sentry::createUser(array(
                'email'       => $input['email'],
                'password'    => $input['password'],
                'name'        => $input['name'],
                'phone'       => $input['phone'],
                'avatar'      => $input['avatar'],
                'description' => $input['description'],
                // 'permissions' => $permissions
            ));

            // activate user
            $activationCode = $user->getActivationCode();

            if (true)
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
                    $message->to($user->getLogin());
                });
            }
        }
        catch (\Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            Message::error('Login field is required.');
            return false;
        }
        catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e)
        {
            Message::error('Password field is required.');
            return false;
        }
        catch (\Cartalyst\Sentry\Users\UserExistsException $e)
        {
            Message::error('User with this login already exists.');
            return false;
        }
        catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
            Message::error('Group was not found.');
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
            $user = Sentry::findUserById($id);

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
        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
            Message::error('User with this login already exists.');
            return false;
        }
        catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
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
            $user = Sentry::findUserById($id);

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
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return ['status'=>'error', 'message'=>pick_trans('user_not_found')];
        }
        catch (\Cartalyst\Sentry\Users\UserAlreadyActivatedException $e)
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
                $user = Sentry::findUserById($var);
            }
            elseif (is_string($var))
            {
                $user = Sentry::findUserByLogin($var);
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
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
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
            $user = Sentry::findUserByResetPasswordCode($input['code']);

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
                    Sentry::logout();
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
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
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
            return ['status'=>true, 'message'=>pick_trans('success_login')];
        } else {
            return ['status'=>false, 'message'=>pick_trans('invalid_email_password')];
        }
    }

}