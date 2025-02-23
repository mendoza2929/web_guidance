<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	public function postLogin(Request $request)
    {
        // $this->validate($request, [
        //     'name' => 'required|name', 'password' => 'required',
        // ]);

        $credentials = $request->only('email', 'password');

        if ($this->auth->attempt($credentials, $request->has('remember')))
        {
            return $this->handleUserWasAuthenticated($request);
        }

        return redirect($this->loginPath())
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors([
                        'email' => $this->getFailedLoginMessage(),
                    ]);
    }

	protected function handleUserWasAuthenticated(Request $request)
    {
        $user = $this->auth->user();

        if ($user->role == 'admin') {
            return redirect()->intended('/admin/index');
        } elseif ($user->role == 'student') {
            return redirect()->intended('/user/index');
        }
		elseif ($user->role == 'teacher') {
            return redirect()->intended('/teacher/dashboard');
        }
		elseif ($user->role == 'parent') {
            return redirect()->intended('/parent/dashboard');
        }


        return redirect()->intended($this->redirectPath());
    }

}
