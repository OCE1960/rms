<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\StoreTranscriptRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Requests\UpdateTranscriptRequest;
use App\Mail\TranscriptRequestMail;
use App\Models\Semester;
use App\Models\Student;
use App\Models\TranscriptRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class StudentController extends Controller
{
    public function index()
    {
        $authUser = auth()->user();
        $semesters = Semester::where('school_id', $authUser->school_id)
            ->orderBy('semester_session', 'asc')->orderBy('semester_name', 'asc')->get();
        $students = User::where('is_student', true)->where('school_id', $authUser->school_id)
            ->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get();

        return view('students.index')->with('students', $students)->with('semesters', $semesters);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $authUser = auth()->user();
        $user = User::updateOrCreate(
            [
                'registration_no' => $request->registration_no,
            ],
            [
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'gender' => $request->gender,
                'profile_picture_path' => $request->profile_picture_pathe,
                'date_of_birth' => $request->date_of_birth,
                'state_of_origin' => $request->state_of_origin,
                'school_id' => $authUser->school_id,
                'is_student' => true,
                'password' => bcrypt($request->password),
            ]
        );

        Student::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'program' => $request->program,
                'date_of_entry' => $request->date_of_entry,
                'mode_of_entry' => $request->mode_of_entry,
            ]
        );

        return $this->sendSuccessMessage('Student sucessfully Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $user = User::find($id);


         if (empty($user)) {
           return $this->sendErrorResponse(['User does not exist']);
        }

       $data = [
            'user' => $user,
            'student' => $user->student,
       ];

       return $this->sendSuccessResponse('User Record Successfully Retrived',$data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, $id)
    {
        $user = User::find($id);

        //Redirect to the Role page if validation fails.
         if (empty($user)) {
           return $this->sendErrorResponse(['User Record does not exist']);
        }

        $authUser = auth()->user();
        User::updateOrCreate(
            [
                'registration_no' => $request->registration_no,
            ],
            [
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'gender' => $request->gender,
                'profile_picture_path' => $request->profile_picture_pathe,
                'date_of_birth' => $request->date_of_birth,
                'state_of_origin' => $request->state_of_origin,
                'school_id' => $authUser->school_id,
                'is_student' => true,
            ]
        );

        Student::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'program' => $request->program,
                'date_of_entry' => $request->date_of_entry,
                'mode_of_entry' => $request->mode_of_entry,
            ]
        );

        return $this->sendSuccessMessage('Semester Result Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        //Redirect to the Role page if validation fails.
         if (empty($user)) {
           return $this->sendErrorResponse(['User record does not exists']);
        }

        $user->delete();

        return $this->sendSuccessMessage('User Successfully deleted');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $authStudent = auth('student')->user();

        $transcriptRequests = TranscriptRequest::where('user_id', $authStudent->id)->orderBy('created_at', 'DESC')->get();

        return view('student-portal.dashboard')->with('transcriptRequests', $transcriptRequests);
    }

    public function logout(Request $request)
    {
        $user_id = auth('student')->id();
        $user = User::find($user_id);
        $user->remember_token = '';
        $user->save();
        auth()->logout();
        $request->session()->flush();
        return redirect('/');

    }

    public function processTranscriptRequest(StoreTranscriptRequest $request)
    {
        $authUser = auth('student')->user();

        $transcriptRequest = new TranscriptRequest();
        $transcriptRequest->user_id = $authUser->id;
        $transcriptRequest->school_id = $authUser->school_id;
        $transcriptRequest->send_by = $request->send_by;
        $transcriptRequest->destination_country = $request->destination_country;
        $transcriptRequest->receiving_institution = $request->receiving_institution;
        $transcriptRequest->receiving_institution_corresponding_email = $request->receiving_institution_corresponding_email;
        $transcriptRequest->program = $request->program;
        $transcriptRequest->title_of_request= $request->title_of_request;
        $transcriptRequest->reason_for_request = $request->reason_for_request;
        $transcriptRequest->save();

        Mail::to('okekechristian1960@yahoo.com')->send(new TranscriptRequestMail($transcriptRequest));

        return $this->sendSuccessMessage('Transcript Request Successfully Created');
    }

    public function updateTranscriptRequest(UpdateTranscriptRequest $request, $id)
    {
        $transcriptRequest = TranscriptRequest::find($request->id);

        //Redirect to the Role page if validation fails.
        if (empty($transcriptRequest)) {
           return $this->sendErrorResponse(['Invalid Transcript']);
        }

        $authUser = auth('student')->user();
        $transcriptRequest->user_id = $authUser->id;
        $transcriptRequest->school_id = $authUser->school_id;
        $transcriptRequest->send_by = $request->send_by;
        $transcriptRequest->destination_country = $request->destination_country;
        $transcriptRequest->receiving_institution = $request->receiving_institution;
        $transcriptRequest->receiving_institution_corresponding_email = $request->receiving_institution_corresponding_email;
        $transcriptRequest->program = $request->program;
        $transcriptRequest->title_of_request= $request->title_of_request;
        $transcriptRequest->reason_for_request = $request->reason_for_request;
        $transcriptRequest->save();

       return $this->sendSuccessMessage('Transcript Successfully Updated');

    }

    public function showTranscriptRequest($id)
    {
        $transcriptRequest = TranscriptRequest::find($id);

        //Redirect to the Role page if validation fails.
         if (empty($transcriptRequest)) {
           return $this->sendErrorResponse(['Invalid Transcript Request']);
        }

       $data = ['transcriptRequest' => $transcriptRequest];

       return $this->sendSuccessResponse('Transcript Request Record Successfully Retrived',$data);

    }

    public function showStudentChangePasswordForm(Request $request)
    {
        return view('student-portal.edit-change-password');
    }

    public function processStudentChangePasswordForm(Request $request)
    {

        $user = auth('student')->user();
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
            return redirect()->route('student.users.profile')->with('success', 'Password Successfully Changed');
        }

    }

    public function showStudentProfile(Request $request)
    {
        $id = auth()->user()->id;
        $user = User::where('id', $id)->where('is_student', true)->first();
        return view('student-portal.view-profile')->with('user', $user);
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

    public function editStudentProfile()
    {
        $authStudent = auth()->user();

        return view('student-portal.edit-profile')->with('student', $authStudent);
    }

    public function updateStudentProfile(UpdateStudentRequest $request)
    {
        //dd($request);
        $userId = auth('student')->user()->id;

        $user = User::find($userId);
        $user->first_name = $request->first_name;
        $user->middle_name= $request->middle_name;
        $user->last_name = $request->last_name;
        $user->gender = $request->gender;
        $user->phone_no = $request->phone_no;
        $user->save();
        return redirect()->route('student.users.profile')->with('success', 'Profile Successfully updated');

    }
}
