<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\LeaveRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::all();
        $users = User::all();
        $leaveRequets = LeaveRequest::all();
        return view('dashboard')->with('roles', $roles)
            ->with('users', $users)
            ->with('leaveRequets', $leaveRequets); 
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
