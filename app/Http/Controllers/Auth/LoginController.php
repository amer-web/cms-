<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function username()
    {
        return 'username';
    }
    protected function authenticated(Request $request, $user)
    {
        if($user->status == 'InActive')
        {
            Auth::logout();
            return redirect('login')->with('error', 'You are prohibited from entering ');
        } else {
            $user->update(['last_login'=> Carbon::now('Africa/Cairo')]);
            if($user->hasRole('admin|editor'))
            {
                return redirect()->route('admin.dashboard');
            }
            return redirect('dashboard')->with('success', 'welcome back ' . $user->username);
        }

    }
    protected function loggedOut(Request $request)
    {
        redirect('/')->with('success', 'You have signed out successfully');
    }


}
