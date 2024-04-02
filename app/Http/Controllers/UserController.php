<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetUserPasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Mail\ResetUserPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Validator;

class UserController extends Controller
{
    public function showChangePasswordForm(Request $request)
    {
        return view('change-password'); 
    }

    public function validateChangePasswordForm( Request $request) {

        $validation_rules = array(
            'password' => 'required',
            'new_password' => 'required|min:6|confirmed|different:password'

        );

        $validation_messages = array(
            'required' => 'The :attribute field is required.',
        );

        $attributes = [
            'password'     => 'Password',
            'new_password' => 'New Password',
        ];

        //Create a validator for the data in the request
        return Validator::make($request->all(), $validation_rules, $validation_messages, $attributes);
    }

    public function processPasswordChange(Request $request)
    {

        $user = auth()->user();
        //create the validator for the Permission.
        $validator = $this->validateChangePasswordForm($request);

        //Redirect to the Permission page if validation fails.
         if ($validator->fails()) {
           return redirect()->back()->withErrors($validator)->withInput();
        }

        if(! Hash::check($request->password, $request->user()->password)) {
            return redirect()->back()->with('error', 'Password does not Match Current Password!!');
        }else{

            $user->password = bcrypt($request->new_password);
            $user->save();
            return redirect()->route('dashboard')->with('success', 'Password Successfully Changed');
        }

    }

    public function showProfile(Request $request)
    {
        $id = auth()->id();
        $user = User::where('id', $id)->first();
        return view('view-profile')->with('user', $user); 
    }

    public function viewStaff(Request $request, $id)
    {

        $user = User::find($id);

        //Redirect to the Role page if validation fails.
         if (empty($user)) {
           return $this->sendErrorResponse(['User does not exist']);
        }

       $roles = $user->roles()->pluck('id');
       $data = [
            'user' => $user,
            'roles' => $roles
        ];

       return $this->sendSuccessResponse('Staff Record Successfully Retrived',$data);
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStaffRequest  $request
     * @param  \App\Models\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(UpdateProfileRequest $request, $id)
    {
 
        $user = User::find($id);

         if (empty($user)) {
            return $this->sendErrorResponse(['User does not exist']);
        }
       
        $user->phone_no = $request->phone_no;
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;

        $user->save();

        return $this->sendSuccessMessage('Staff Successfully Updated');
       
    }

    public function resetPassword(ResetUserPasswordRequest $request, $id)
    {
 
        $user = User::find($id);

         if (empty($user)) {
            return $this->sendErrorResponse(['User does not exist']);
        }

        $password = $request->password;
        $user->password = bcrypt($password);
        $user->save();

        Mail::to($user->email)->send(new ResetUserPassword($password));

       return $this->sendSuccessMessage('Staff Password Successfully Reset');
       
    }
}
