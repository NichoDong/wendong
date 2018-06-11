<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function validateLogin(Request $request)
    {
        $rule = [
            $this->username() => 'required|string',
            'password' => 'required|string',
        ];

        $msg = [
            'captcha.required' => '验证码不能为空！',
            'captcha' => '验证码不正确',
        ];

        if(config('app.env') === 'production') {
            $rule['one_time_password'] = 'required|google2fa';

            $msg['one_time_password.required'] = '2步验证码不能为空！';
            $msg['google2fa'] = '2步验证码不正确';
        }
        $this->validate($request, $rule, $msg);
    }
}
