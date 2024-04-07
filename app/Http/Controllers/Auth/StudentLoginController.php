<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;


class StudentLoginController extends Controller
{
   // protected $redirectTo = RouteServiceProvider::STUDENT;
   
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        
    }

    public function authenticate(Request $request)
    {

        //create the validator for login
        $validator = $this->validateAuthenticate($request);

        //Redirect to the create page if validation fails.
         if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

       // $credentials = $request->only('email', 'password');

         if (Auth::guard('student')->attempt(['email' => $request->email, 'password' => $request->password, 'is_student'=> 1], $request->remember)) {
            // Authentication passed...
            $authUser = Auth::guard('student')->user();

            return redirect()->intended('students/dashboard');
            
        }else if (Auth::guard('student')->attempt(['registration_no' => $request->email, 'password' => $request->password, 'is_student'=> 1], $request->remember)) {
            // Authentication passed...
            $authUser = Auth::guard('student')->user();
            return redirect()->intended('students/dashboard');
        }
        else{
            return redirect()->route('web.student.login')->with('invalid-details', 'invalid login details');
        }
    }

    public function validateAuthenticate( Request $request) {

        $validation_rules = array(
            'email' => 'required',
            'password' => 'required'

        );

        $validation_messages = array(
            'required' => 'The :attribute field is required.',
        );

        $attributes = [
            'email'     => 'Email',
            'password'     => 'Password'
        ];

        //Create a validator for the data in the request
        return Validator::make($request->all(), $validation_rules, $validation_messages, $attributes);

    }
}
