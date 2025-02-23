<?php

namespace App\Http\Controllers\Auth;

use App\Classification;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {

	    // $classification_list = Classification::all();
        // dd($classification_list);

        return view('auth.register',compact('classification_list'));
    }

    

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->student_no = $request->student_no;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'student';
        $user->is_new = 1;
        $user->save();
        

        Auth::login($user);

        return redirect('/auth/login');
    }


}