<?php

namespace App\Http\Controllers;


use App\Http\Requests\ActivateStudentRequest;
use App\Http\Requests\UpdateEnquirerRequest;
use App\Http\Requests\StoreResultVerificationRequestRequest;
use App\Http\Requests\UpdateResultVerificationRequestRequest;
use App\Models\Enquirer;
use App\Models\School;
use App\Models\User;
use App\Models\ResultVerificationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResultVerifierAccount;
use Illuminate\Support\Facades\Mail;
use App\Models\Attachment;

class EnquirerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $authStudent = Auth::user();

        $schools = School::all();

        $veryResultRequests = ResultVerificationRequest::where('enquirer_user_id', $authStudent->id)->orderBy('created_at', 'DESC')->get();

        return view("enquirer-portal.dashboard")->with('veryResultRequests', $veryResultRequests)->with('schools', $schools);
    }

    public function showLoginForm()
    {

        return view("auth.result-verifier-login");
    }


    public function showAccountActivateForm()
    {

        return view("auth.verify-result-activate");
    }

    public function processAccountActivate(ActivateStudentRequest $request)
    {
        $user = User::where('id', $request->activation_code)
                ->where('is_result_enquirer', true)->first();

        if ($user) {

            $name = $user->full_name;
            if ($user->is_account_activated == 0) {
                $user->is_account_activated = true;
                $user->save();
                return redirect()->route('web.verify.result.login')
                ->with('success',"{$name}, your account has been successfully activated, login to start session");
            } else {
                return redirect()->route('verify.result.activate')
                ->with('error',"$name, Your account has been activated earlier before, please login to continue session");
            }

        } else {
            return redirect()->route('student.activate')
                ->with('error',"Invalid Activation Code");
        }

    }

    public function logout(Request $request)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $user->remember_token = '';
        $user->save();
        Auth::logout();
        $request->session()->flush();
        return redirect('/');

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStudentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEnquirerRequest $request)
    {
        $user = new User;
        $user->email = $request->email;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->is_disabled = false;
        $user->is_result_enquirer = true;
        $user->is_account_activated = false;
        $user->password = bcrypt($request->password);
        $user->created_by = Auth::id();
        $user->save();

        $resultVerifier = new Enquirer;
        $resultVerifier->user_id = $user->id;
        $resultVerifier->save();


        Mail::to($user->email)->send(new ResultVerifierAccount($user));

        return redirect()->route('verify.result.register')->with('success', 'Account Successfully created, please check your mail to activate your account');
    }

    public function editResultVerifierProfile()
    {
        $authStudent = Auth::user();

        return view('enquirer-portal.edit-profile')->with('resultVerifier', $authStudent);
    }

    public function updateResultVerifierProfile(UpdateEnquirerRequest $request)
    {
        $userId = Auth::id();

        $user = User::find($userId);
        $user->first_name = $request->first_name;
        $user->middle_name= $request->middle_name;
        $user->last_name = $request->last_name;
        $user->gender = $request->gender;
        $user->phone_no = $request->phone_no;
        $user->save();

        $resultVerifier = Enquirer::where('user_id', $userId )->first();
        $resultVerifier->organization_name = $request->organization_name;
        $resultVerifier->save();

        return redirect()->route('verify.result.users.profile')->with('success', 'Profile Successfully updated');
    }

    public function processVerifyResultRequest(StoreResultVerificationRequestRequest $request)
    {
        $authUser = auth()->user();
        $verifyResultRequest = new ResultVerificationRequest();
        $verifyResultRequest->enquirer_user_id = $authUser->id;
        $verifyResultRequest->student_first_name = $request->student_first_name;
        $verifyResultRequest->student_middle_name = $request->student_middle_name;
        $verifyResultRequest->student_last_name = $request->student_last_name;
        $verifyResultRequest->registration_no = $request->registration_no;
        $verifyResultRequest->school_id = $request->school_id;
        $verifyResultRequest->reason_for_request = $request->reason_for_request;
        $verifyResultRequest->title_of_request = $request->title_of_request;

        $verifyResultRequest->save();

        if ($request->hasFile('file_path')) {

            $file_path = $this->storeDocument($request, 'file_path');

            $attachment = new Attachment();
            $attachment->file_path = $file_path;
            $attachment->created_by = $authUser->id;
            $attachment->label = 'Result Verification Request';
            $attachment->description = "This document contains the result verification request";
            $attachment->file_type =  "pdf";
            $attachment->requester_user_id =  $verifyResultRequest->verifier_user_id;
            $attachment->result_verification_request_id =  $verifyResultRequest->id;
            $attachment->save();
        }

        return $this->sendSuccessMessage('Transcript Request Successfully Created');
    }

    public function showVerifyResultRequest($id)
    {
        $verifyResultRequest = ResultVerificationRequest::find($id);

        //Redirect to the Role page if validation fails.
         if (empty($verifyResultRequest)) {
           return $this->sendErrorResponse(['Invalid Verify Result Request']);
        }

       $data = [
            'verifyResultRequest' => $verifyResultRequest,
            'school' => $verifyResultRequest->school?->full_name
        ];

       return $this->sendSuccessResponse('Verify Result Request Record Successfully Retrived',$data);

    }

    public function updateVerifyResultRequest(UpdateResultVerificationRequestRequest $request, $id)
    {
        $file_path = null;
        $authUser = auth()->user();
        $verifyResultRequest = ResultVerificationRequest::find($request->id);
        $oldFilePath = null;


        //Redirect to the Role page if validation fails.
        if (empty($verifyResultRequest)) {
           return $this->sendErrorResponse(['Invalid Verify Transcript Request ']);
        }

        $verifyResultRequest->student_first_name = $request->student_first_name;
        $verifyResultRequest->student_middle_name = $request->student_middle_name;
        $verifyResultRequest->student_last_name = $request->student_last_name;
        $verifyResultRequest->registration_no = $request->registration_no;
        $verifyResultRequest->school_id = $request->school_id;
        $verifyResultRequest->reason_for_request = $request->reason_for_request;
        $verifyResultRequest->title_of_request = $request->title_of_request;
        $verifyResultRequest->save();

        if ($request->hasFile('file_path')) {

            $file_path = $this->storeDocument($request, 'file_path');

            $attachment = Attachment::where('result_verification_request_id', $verifyResultRequest->id)
                ->where('label', 'Result Verification Request')->first();

            if ($attachment != null) {
                $oldFilePath = $attachment->file_path;
            }
            if ($attachment == null) {
                $attachment = new Attachment();
            }

            $attachment->file_path = $file_path;
            $attachment->created_by = $authUser->id;
            $attachment->label = 'Result Verification Request';
            $attachment->description = "This document contains the result verification request";
            $attachment->file_type =  "pdf";
            $attachment->requester_user_id =  $verifyResultRequest->verifier_user_id;
            $attachment->result_verification_request_id =  $verifyResultRequest->id;
            $attachment->save();

            if (($oldFilePath) && file_exists(public_path($oldFilePath))) {
                unlink(public_path($oldFilePath));
            }
        }

       return $this->sendSuccessMessage('Verify Result Successfully Updated');

    }

    public function handleVerifyResultPayment(Request $request)
    {
        $payment_transcript_id = $request->payment_transcript_id;
        $response = PayStack::makePayment($request->amount, $request->email, $request->callback_url, $request->metadata);
        return $this->sendSuccessResponse('Transcript Request Record Successfully Retrived',$response->json());
    }

    public function showResultVerifierChangePasswordForm(Request $request)
    {
        return view('enquirer-portal.edit-change-password');
    }

    public function processResultVerifierChangePasswordForm(Request $request)
    {

        $user = Auth::user();
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
            return redirect()->route('verify.result.users.profile')->with('success', 'Password Successfully Changed');
        }

    }

    public function showResultVerifierProfile(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->where('is_result_enquirer', true)->first();
        return view('enquirer-portal.view-profile')->with('user', $user);
    }

    public function validateChangePasswordForm( Request $request)
    {

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

    public function register()
    {
        return view('auth.verify-result-register');
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

         if (Auth::guard('result-verifier')->attempt(['email' => $request->email, 'password' => $request->password, 'is_result_enquirer'=> 1], $request->remember)) {
            // Authentication passed...
            $authUser = Auth::guard('result-verifier')->user();

            return redirect()->intended('enquirers/dashboard');

        } else {
            return redirect()->route('verify.result.login')->with('invalid-details', 'invalid login details');
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
