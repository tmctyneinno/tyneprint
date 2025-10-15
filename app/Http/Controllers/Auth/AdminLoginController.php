<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class AdminLoginController extends Controller
{   
    public function showLogin(){
        return view('auth.admin-login');
    }

    protected function guard(){

        return Auth::guard('admin');

    }

    use AuthenticatesUsers;
/**
     * Where to redirect users after login.
     *
     * @var string
     */
    
    protected $redirectTo = 'manage/index';
/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }
}
