<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivateStudentRequest;
use App\Http\Requests\BulkUploadRequest;
use App\Http\Requests\ResetUserPasswordRequest;
use App\Http\Requests\StoreGuestStudentRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Mail\ResetUserPassword;
use App\Models\School;
use App\Models\Semester;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Mail\StudentResultVerifierAccount;
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
                            'registration_no' => trim($data[3]),
                        ],
                        [
                            'phone_no' =>trim($data[4]),
                            'email' => trim($data[2]),
                            'password' => bcrypt('password'),
                            'is_student' => true,
                            'is_disabled' => false,
                            'first_name' => trim($data[0]),
                            'last_name' =>trim($data[1]),
                            'school_id' => $authUser->school_id,
                            'created_by' => $authUser->id,
                        ]
                    );

                    Student::updateOrCreate(
                        [
                            'user_id' => $user->id,
                        ],
                        [
                            'department' => trim($data[5]),
                            'program' => trim($data[6]),
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
                        $invalids['inc'] = 'The file format is incorrect. Must be - "first_name,last_name,email,registration_no,phone_no,department,program"';
                        array_push($errors, $invalids);
                        break;
                    }

                    if (trim(strtolower($headers[3])) != 'registration_no') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "first_name,last_name,email,registration_no,phone_no,department,program"';
                        array_push($errors, $invalids);
                        break;
                    }

                    if (trim(strtolower($headers[4])) != 'phone_no') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "first_name,last_name,email,registration_no,phone_no,department,program"';
                        array_push($errors, $invalids);
                        break;
                    }

                    if (trim(strtolower($headers[5])) != 'department') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "first_name,last_name,email,registration_no,phone_no,department,program"';
                        array_push($errors, $invalids);
                        break;
                    }

                    if (trim(strtolower($headers[6])) != 'program') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "first_name,last_name,email,registration_no,phone_no,department,program"';
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

    public function getStudents()
    {
        $authUser = auth()->user();
        $semesters = Semester::where('school_id', $authUser->school_id)
            ->orderBy('semester_session', 'asc')->orderBy('semester_name', 'asc')->get();
        $students = User::where('is_student', true)->orderBy('first_name', 'asc')
            ->orderBy('last_name', 'asc')->get();

        return view('students.index')->with('students', $students)->with('semesters', $semesters);
    }

    /**
     * Display a listing of the resource.
     */
    public function getStaffs()
    {
        $users = User::where('is_staff', true)->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get();

        return view('staffs.index')->with('users', $users);
    }

    /**
     * Display a listing of the resource.
     */
    public function getResultEnquirers()
    {
        $users = User::where('is_result_enquirer', true)->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get();

        return view('result-enquirers.index')->with('users', $users);
    }

    public function viewStudent($id)
    {
        $user = User::findOrFail($id);

        return view('students.show')->with('user', $user);
    }

    public function showStudentLoginForm()
    {

        return view("auth.student-login");
    }

    public function registerStudent()
    {
        $schools = School::orderBy('full_name', 'asc')->get();

        return view('auth.student-register')->with('schools', $schools);
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGuestStudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeStudent(StoreGuestStudentRequest $request)
    {
        $user = User::updateOrCreate(
            [
                'registration_no' => $request->registration_no,
            ],
            [
                'email' => $request->email,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'school_id' => $request->school_id,
                'is_account_activated' => false,
                'is_disabled' => false,
                'is_student' => true,
                'password' => bcrypt($request->password),
            ]
        );

        Student::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'department' => $request->department,
            ]
        );

        Mail::to($user->email)->send(new StudentResultVerifierAccount($user));

        return redirect()->route('web.student.register')->with('success', 'Account Successfully created, please check your mail to activate your account');
    }

    public function showAccountActivateForm()
    {

        return view("auth.student-activate");
    }

    public function processAccountActivate(ActivateStudentRequest $request)
    {
        $user = User::where('id', $request->activation_code)
                ->where('is_student', true)->first();

        if ($user) {

            $name = $user->full_name;
            if ($user->is_account_activated == 0) {
                $user->is_account_activated = true;
                $user->save();
                return redirect()->route('web.student.login')
                ->with('success',"{$name}, your account has been successfully activated, login to start session");
            } else {
                return redirect()->route('student.activate')
                ->with('error',"$name, Your account has been activated earlier before, please login to continue session");
            }

        } else {
            return redirect()->route('student.activate')
                ->with('error',"Invalid Activation Code");
        }

    }


}
