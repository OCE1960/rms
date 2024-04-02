<?php

namespace App\Http\Controllers;

use App\Http\Requests\BulkUploadRequest;
use App\Http\Requests\ResetUserPasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Mail\ResetUserPassword;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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

    public function processStudentBulkUpload(BulkUploadRequest $request)
    {
      $filePath = $this->storeFile($request, 'bulk_upload_file');
      $authUser = auth()->user();
       $errors = [];
        $loop = 1;
        $lines = file($filePath);
        if (count($lines) > 1) {
            foreach ($lines as $line) {
                // skip first line (heading line)
                if ($loop > 1) {
                    $data = explode(',', $line);
                    // dd($data);
                    $invalids = $this->validateStudentValues($data);
                  if (count($invalids) > 0) {
                    array_push($errors, $invalids);
                    continue;
                  }else{

                    $user = User::updateOrCreate(
                        [
                            'registration_no' =>$data[3],
                        ],
                        [
                            'phone_no' => $data[4],
                            'email' => $data[2],
                            'password' => bcrypt('password'),
                            'is_student' => true,
                            'is_disabled' => false,
                            'first_name' => $data[0],
                            'last_name' => $data[1],
                            'school_id' => $authUser->school_id,
                            'created_by' => $authUser->id,
                        ]
                    );

                    Student::updateOrCreate(
                        [
                            'user_id' => $user->id,
                        ],
                        [
                            'department' => $data[5],
                            'program' => $data[6],
                        ]
                    );
                  }
                }else{
                    $headers = explode(',', $line);
                    if (trim(strtolower($headers[1])) != 'last_name') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "first_name,last_name,email,registration_no,phone_no1"';
                        array_push($errors, $invalids);
                        break;
                    }

                    if (trim(strtolower($headers[2])) != 'email') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "first_name,last_name,email,registration_no,phone_no2"';
                        array_push($errors, $invalids);
                        break;
                    }

                    if (trim(strtolower($headers[3])) != 'registration_no') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "first_name,last_name,email,registration_no,phone_no, "';
                        array_push($errors, $invalids);
                        break;
                    }

                    if (trim(strtolower($headers[4])) != 'phone_no') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "first_name,last_name,email,registration_no,phone_no4"';
                        array_push($errors, $invalids);
                        break;
                    }

                    if (trim(strtolower($headers[5])) != 'department') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "first_name,last_name,email,registration_no,phone_no5"';
                        array_push($errors, $invalids);
                        break;
                    }

                    if (trim(strtolower($headers[6])) != 'program') {
                        $invalids['inc'] = strtolower($headers[6]);
                        array_push($errors, $invalids);
                        break;
                    }
                }
                $loop++;
            }   
        }else{
            $errors[] = 'The uploaded csv file is empty';
        }

        File::delete($filePath);

        if (count($errors) > 0) {
            $collectErrors = $this->array_flatten($errors);

            return $this->sendErrorResponse($collectErrors);  
        }

        return $this->sendSuccessMessage('Student Bulk Upload Successful');
    }

    public function validateStudentValues($data)
    {
        $errors = [];

        // validte email
         if (!filter_var($data[2], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'The email: '.$data[2].' is invalid';
        }
         
     

        $user = User::where('email', $data[2])->where('registration_no', '<>', $data[3])->first();
        if ($user) {
            $errors[] = 'The email: '.$data[2].' already belongs to a user';
        } 

        // validate matric number
        $registration_no = User::where('registration_no', $data[3])->where('email', '<>', $data[2])->first();
        if ($registration_no) {
            $errors[] = 'The Registration number: '.$data[3].' already belongs to a student';
        }

        // validate phone number
        $phone_no = User::where('phone_no', $data[4])->where('registration_no', '<>', $data[3])->first();
        if ($phone_no) {
            $errors[] = 'The telephone number: '.$data[4].' already belongs to a User';
        }
        return $errors;
    }
}
