<?php

namespace Sharenjoy\Cmsharenjoy\User;

class LoginRequiredException extends \UnexpectedValueException {}
class PasswordRequiredException extends \UnexpectedValueException {}
class UserAlreadyActivatedException extends \RuntimeException {}
class UserNotFoundException extends \OutOfBoundsException {}
class UserNotActivatedException extends \RuntimeException {}
class UserExistsException extends \UnexpectedValueException {}
class WrongPasswordException extends UserNotFoundException {}
