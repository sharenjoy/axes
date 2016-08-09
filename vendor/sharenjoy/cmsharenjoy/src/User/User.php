<?php namespace Sharenjoy\Cmsharenjoy\User;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Sharenjoy\Cmsharenjoy\Core\Traits\CommonModelTrait;
use Sharenjoy\Cmsharenjoy\User\ActivableRemindableResetable;

class User extends Authenticatable
{
    use CommonModelTrait;
    use ActivableRemindableResetable;

    protected $table = 'users';

    protected $fillable = [
        'email',
        'password',
        'name',
        'phone',
        'avatar',
        'description'
    ];

    protected $eventItem = [];

    public $filterFormConfig = [];

    public $formConfig = [
        'avatar'                => ['order' => '5', 'help'=>'建議尺寸180x180px', 'size'=>'180x180'],
        'name'                  => ['order' => '10'],
        'email'                 => ['order' => '20'],
        'phone'                 => ['order' => '30'],
        'password'              => ['order' => '40', 'update'=>'deny'],
        'password_confirmation' => ['order' => '50', 'update'=>'deny'],
        'description'           => ['order' => '60'],
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'reset_password_code',
        'activation_code'
    ];

    public function listQuery()
    {
        return $this->orderBy('created_at', 'DESC');
    }

}