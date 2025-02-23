<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected $redirectTo = '/auth/login';

    public function login(Request $request)
    {
        $this->validate($request, [
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role == 'admin') {
            return redirect()->intended('/admin/index');
        } elseif ($user->role == 'student') {
            return redirect()->intended('/user/index');
        }
        elseif ($user->role == 'parent') {
            return redirect()->intended('/parent/dashboard');
        }
        
        

        return redirect()->intended($this->redirectTo);
    }
}