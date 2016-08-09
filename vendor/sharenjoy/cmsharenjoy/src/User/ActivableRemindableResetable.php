<?php

namespace Sharenjoy\Cmsharenjoy\User;

use Sharenjoy\Cmsharenjoy\User\UserExistsException;
use Sharenjoy\Cmsharenjoy\User\LoginRequiredException;
use Sharenjoy\Cmsharenjoy\User\PasswordRequiredException;
use Sharenjoy\Cmsharenjoy\User\UserAlreadyActivatedException;

trait ActivableRemindableResetable
{
    /**
     * The login attribute.
     *
     * @var string
     */
    protected static $loginAttribute = 'email';

    /**
     * Get an activation code for the given user.
     *
     * @return string
     */
    public function getActivationCode()
    {
        $this->activation_code = $activationCode = $this->getRandomString();

        $this->save();

        return $activationCode;
    }

    /**
     * Attempts to activate the given user by checking
     * the activate code. If the user is activated already,
     * an Exception is thrown.
     *
     * @param  string  $activationCode
     * @return bool
     * @throws \Sharenjoy\Cmsharejoy\User\UserAlreadyActivatedException
     */
    public function attemptActivation($activationCode)
    {
        if ($this->activated) {
            throw new UserAlreadyActivatedException('Cannot attempt activation on an already activated user.');
        }

        if ($activationCode == $this->activation_code) {
            $this->activation_code = null;
            $this->activated       = true;
            $this->activated_at    = $this->freshTimestamp();

            return $this->save();
        }

        return false;
    }

    /**
     * Returns the name for the user's login.
     *
     * @return string
     */
    public function getLoginName()
    {
        return static::$loginAttribute;
    }

    /**
     * Get a reset password code for the given user.
     *
     * @return string
     */
    public function getResetPasswordCode()
    {
        $this->reset_password_code = $resetCode = $this->getRandomString();

        $this->save();

        return $resetCode;
    }

    /**
     * Finds a user by the login value.
     *
     * @param  string  $login
     * @return \Sharenjoy\Cmsharenjoy\User\UserInterface
     * @throws \Sharenjoy\Cmsharenjoy\User\UserNotFoundException
     */
    public function findByLogin($login)
    {
        if ( ! $user = $this->newQuery()->where($this->getLoginName(), '=', $login)->first()) {
            throw new \Sharenjoy\Cmsharenjoy\User\UserNotFoundException("A user could not be found with a login value of [$login].");
        }

        return $user;
    }

    /**
     * Finds a user by the given reset password code.
     *
     * @param  string  $code
     * @return \Sharenjoy\Cmsharenjoy\User\UserInterface
     * @throws RuntimeException
     * @throws \Sharenjoy\Cmsharenjoy\User\UserNotFoundException
     */
    public function findByResetPasswordCode($code)
    {
        $result = $this->newQuery()->where('reset_password_code', '=', $code)->get();

        if (($count = $result->count()) > 1) {
            throw new \RuntimeException("Found [$count] users with the same reset password code.");
        }

        if ( ! $user = $result->first()) {
            throw new \Sharenjoy\Cmsharenjoy\User\UserNotFoundException("A user was not found with the given reset password code.");
        }

        return $user;
    }

    /**
     * Checks if the provided user reset password code is
     * valid without actually resetting the password.
     *
     * @param  string  $resetCode
     * @return bool
     */
    public function checkResetPasswordCode($resetCode)
    {
        return ($this->reset_password_code == $resetCode);
    }

    /**
     * Attempts to reset a user's password by matching
     * the reset code generated with the user's.
     *
     * @param  string  $resetCode
     * @param  string  $newPassword
     * @return bool
     */
    public function attemptResetPassword($resetCode, $newPassword)
    {
        if ($this->checkResetPasswordCode($resetCode)) {
            $this->password = bcrypt($newPassword);
            $this->reset_password_code = null;

            return $this->save();
        }

        return false;
    }

    /**
     * Generate a random string.
     *
     * @return string
     */
    public function getRandomString($length = 42)
    {
        // We'll check if the user has OpenSSL installed with PHP. If they do
        // we'll use a better method of getting a random string. Otherwise, we'll
        // fallback to a reasonably reliable method.
        if (function_exists('openssl_random_pseudo_bytes')) {
            // We generate twice as many bytes here because we want to ensure we have
            // enough after we base64 encode it to get the length we need because we
            // take out the "/", "+", and "=" characters.
            $bytes = openssl_random_pseudo_bytes($length * 2);
            // We want to stop execution if the key fails because, well, that is bad.
            if ($bytes === false) {
                throw new \RuntimeException('Unable to generate random string.');
            }

            return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
        }

        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

}