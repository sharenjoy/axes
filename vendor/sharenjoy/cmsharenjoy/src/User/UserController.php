<?php namespace Sharenjoy\Cmsharenjoy\User;

use Sharenjoy\Cmsharenjoy\Http\Controllers\ObjectBaseController;

class UserController extends ObjectBaseController {

    protected $functionRules = [
        'list'           => true,
        'create'         => true,
        'update'         => true,
        'delete'         => true,
        'remindpassword' => true,
    ];

    protected $listConfig = [
        'name'         => ['name'=>'name',         'align'=>'',       'width'=>''   ],
        'phone'        => ['name'=>'cellphone',    'align'=>'',       'width'=>''   ],
        'email'        => ['name'=>'email',        'align'=>'',       'width'=>''   ],
        'created_at'   => ['name'=>'created',      'align'=>'center', 'width'=>'20%'],
    ];

    public function __construct(UserInterface $repo)
    {
        $this->repo = $repo;
        
        parent::__construct();
    }

    public function getRemindpassword($id)
    {
        $result = $this->repo->remindPassword($id);

        if ( ! $result['status'])
        {
            error($result['message']);

            return redirect()->back();
        }

        success($result['message']);

        return redirect($this->objectUrl);
    }

}