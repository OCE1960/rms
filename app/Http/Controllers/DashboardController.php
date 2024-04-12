<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\ResultVerificationRequest;
use App\Models\Role;
use App\Models\School;
use App\Models\TranscriptRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $authUser = Auth::user();
        $admin = Role::where('key', 'super-admin')->first();
        $registry = Role::where('key', 'registry')->first();
        $transcriptRequests = TranscriptRequest::orderBy('created_at', 'asc')->get();
        $resultVerificationRequests = ResultVerificationRequest::orderBy('created_at', 'asc')->get();
        $schools = School::all();
        $staffs = User::where('is_staff', true)->get();
        $students = User::where('is_student', true)->get();
        $users = User::all();

        if (($authUser->hasRole($admin->id)) || ($authUser->hasRole($registry->id)) ) {
            $transcriptRequests = $transcriptRequests;
            $resultVerificationRequests = $resultVerificationRequests;
            $schools = $schools;
            $staffs = $staffs;
            $students = $students;
        } else {
            $transcriptRequests = $transcriptRequests->where('school_id', $authUser->school_id);
            $resultVerificationRequests = $resultVerificationRequests->where('school_id', $authUser->school_id);
            $schools = $schools->where('id', $authUser->school_id);
            $staffs = $staffs->where('school_id', $authUser->school_id);
            $students = $students->where('school_id', $authUser->school_id);
        }

        return view('dashboard')->with('transcriptRequests', $transcriptRequests)
            ->with('users', $users)
            ->with('staffs', $staffs)
            ->with('students', $students)
            ->with('resultVerificationRequests', $resultVerificationRequests)
            ->with('schools', $schools);
    }

    public function getUsers()
    {
        $users = User::all();
        $roles = Role::all();
        return view('users')->with('users', $users)
            ->with('roles', $roles);
    }

    public function store(StoreUserRequest $request)
    {

        $user = new User;
        $user->email = $request->email;
        $user->phone_no = $request->phone_no;
        $user->password = bcrypt($request->password);
        $user->name = $request->name;
        $user->save();

        $user->roles()->sync($request->role);

       return $this->sendSuccessMessage('Staff Record Successfully Saved');

    }

    public function viewUser(Request $request, $id)
    {

        $user = User::find($id);

        //Redirect to the Role page if validation fails.
         if (empty($user)) {
           return $this->sendErrorResponse(['User does not exist']);
        }
        $role = $user->roles;
       $data = ['user' => $user,
                'role' => is_array($role) ? $role[0] : null
                ];

       return $this->sendSuccessResponse('Staff Record Successfully Retrived',$data);

    }

    public function update(UpdateUserRequest $request, $id)
    {

        $user = User::find($id);

         if (empty($user)) {
            return $this->sendErrorResponse(['User does not exist']);
        }

        $user->email = $request->email;
        $user->phone_no = $request->phone_no;
        $user->name = $request->name;
        $user->save();

        $user->roles()->sync($request->role);

        return $this->sendSuccessMessage('Staff Successfully Updated');

    }
}
