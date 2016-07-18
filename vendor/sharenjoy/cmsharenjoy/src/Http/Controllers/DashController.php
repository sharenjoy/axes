<?php

namespace Sharenjoy\Cmsharenjoy\Http\Controllers;

use Illuminate\Http\Request;
use Sharenjoy\Cmsharenjoy\User\UserInterface;
use Auth, Message, Session;

class DashController extends BaseController
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('admin.auth', ['only'=>['getIndex', 'getLogout']]);
        $this->middleware('admin.guest', ['except'=>['getIndex', 'getLogout']]);
    }

    /**
     * Main users page.
     *
     * @access   public
     * @return   View
     */
    public function getIndex()
    {
        return view('admin.unity.dashboard');
    }

    /**
     * Log the user out
     * 
     * @return Redirect
     */
    public function getLogout()
    {
        Auth::logout();

        Session::flush();

        Message::success(pick_trans('success_logout'));

        return redirect($this->accessUrl.'/login');
    }

    /**
     * Login form page.
     *
     * @access   public
     * @return   View
     */
    public function getLogin()
    {
        // If logged in, redirect to admin area
        if (Auth::check())
        {
            return redirect($this->accessUrl);
        }

        return view('admin.unity.login');
    }

    /**
     * Login form processing.
     *
     * @access   public
     * @return   Redirect
     */
    public function postLogin(UserInterface $user, Request $request)
    {
        if ( ! $user->setInput($request->all())->validate('', 'loginRules', 'flash'))
        {
            return redirect($this->accessUrl.'/login')->withInput();
        }

        $result = $user->login($request->all());

        if ( ! $result['status'])
        {
            Message::error($result['message']);

            return redirect($this->accessUrl.'/login')->withInput();
        }

        Message::success($result['message']);

        return redirect($this->accessUrl);
    }

    /**
     * To activate an user via activation code
     * @return void
     */
    public function getActivate(UserInterface $user, $id, $code)
    {
        $result = $user->activate($id, $code);

        Message::{$result['status']}($result['message']);

        return redirect($this->accessUrl.'/login');
    }

    /**
     * To reset an user password
     * @param  string $id
     * @param  string $code The code needs to valid
     * @return object Redirect
     */
    public function getResetpassword($code)
    {
        return view('admin.unity.reset-password')->with('code', $code);
    }

    public function postResetpassword(UserInterface $user, Request $request)
    {
        $result = $user->resetPassword($request->all());

        if ( ! $result['status'])
        {
            Message::error($result['message']);

            return redirect()->back();
        }

        Message::success($result['message']);

        return redirect($this->accessUrl.'/login');
    }

    public function getRemindpassword()
    {
        return view('admin.unity.remind-password');
    }

    public function postRemindpassword(UserInterface $user, Request $request)
    {
        $result = $user->remindPassword($request->input('email'));

        if ( ! $result['status'])
        {
            Message::error($result['message']);

            return redirect()->back();
        }

        Message::success($result['message']);

        return redirect($this->accessUrl.'/remindpassword');
    }

}