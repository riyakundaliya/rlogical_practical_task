<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function login(Request $request)
    {
        // dd($request->all());
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
           
            return redirect()->route('admin.index');
        } 
        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            // dd('here');
            return redirect()->route('front.products');
        }
        // return back()->withErrors([
        //     'email' => 'The provided credentials do not match our records.',
        // ]);
    }

    protected function authenticated(Request $request, $user)
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.index');
        } 
        else{
          
            return redirect()->route('front.products');
        }
        
    }

    public function redirectTo()
    {
       if (Auth::guard('admin')->check()) {
            return route('admin.index');
        } 
        elseif (Auth::guard('user')->check()) {
            return route('front.products');
        } 
        
         else {
            return route('home');
        }
    }
}
