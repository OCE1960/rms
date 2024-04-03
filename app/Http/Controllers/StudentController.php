<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Semester;
use App\Models\Student;
use App\Models\User;

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
}
