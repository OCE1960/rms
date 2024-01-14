<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

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

    public function login(Request $request)
    {

        //create the validator for login
        $validator = $this->validateAuthenticate($request);

        //Redirect to the create page if validation fails.
         if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

       // $credentials = $request->only('email', 'password');

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            // Authentication passed...
            return redirect()->intended('dashboard');
            
        }else{
            return redirect('login')->with('invalid-details', 'invalid login details');
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
