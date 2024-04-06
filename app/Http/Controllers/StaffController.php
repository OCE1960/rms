<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\Staff;
use App\Models\User;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authUser = auth()->user();
        $users = User::where('is_staff', true)->where('school_id', $authUser->school_id)
            ->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get();

        return view('staffs.index')->with('users', $users); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStaffRequest $request)
    {
        $authUser = auth()->user();
        $schoolId = $authUser->school_id;
        if ($request->school_id) {
            $schoolId = $request->school_id;
        }
        $user = User::updateOrCreate(
            [
                'email' => $request->email,
            ], 
            [
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name, 
                'phone_no' => $request->phone_no, 
                'gender' => $request->gender, 
                'profile_picture_path' => $request->profile_picture_pathe,
                'date_of_birth' => $request->date_of_birth,
                'state_of_origin' => $request->state_of_origin, 
                'school_id' => $schoolId,
                'is_staff' => true,
                'created_by' => $authUser->id,
                'password' => bcrypt($request->password),          
            ]
        );

        Staff::updateOrCreate(
            [
                'user_id' => $user->id,
            ], 
            [
                'date_of_entry' => $request->date_of_entry,
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
            'staff' => $user->staff,
       ];

       return $this->sendSuccessResponse('User Record Successfully Retrived',$data);
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStaffRequest $request, $id)
    {
        $user = User::find($id);

        //Redirect to the Role page if validation fails.
         if (empty($user)) { 
           return $this->sendErrorResponse(['User Record does not exist']);
        }

        $authUser = auth()->user();
        $schoolId = $authUser->school_id;
        if ($request->school_id) {
            $schoolId = $request->school_id;
        }
        User::updateOrCreate(
            [
                'email' => $request->email,
            ], 
            [
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'phone_no' => $request->phone_no, 
                'gender' => $request->gender, 
                'profile_picture_path' => $request->profile_picture_pathe,
                'date_of_birth' => $request->date_of_birth,
                'state_of_origin' => $request->state_of_origin, 
                'school_id' => $schoolId,
                'updated_by' => $authUser->id,
                'is_staff' => true,         
            ]
        );

        Staff::updateOrCreate(
            [
                'user_id' => $user->id,
            ], 
            [
                'date_of_entry' => $request->date_of_entry,
            ]
        );

        return $this->sendSuccessMessage('Semester Result Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
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
