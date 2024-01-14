<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveLeaveRequestRequest;
use App\Http\Requests\StoreLeaveRequestRequest;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaveRequets = LeaveRequest::all();
        return view('leave-requests')->with('leaveRequets', $leaveRequets); 
    }

    public function viewLeaveRequest(Request $request, $id)
    {

        $leaveRequest = LeaveRequest::find($id);

         if (empty($leaveRequest)) {
           return $this->sendErrorResponse(['Invalid LeaveREquest does not exist']);
        }
       $data = ['leaveRequest' => $leaveRequest];

       return $this->sendSuccessResponse('LeaveRequest Record Successfully Retrived',$data);
       
    }

    public function processLeaveRequestApproval(ApproveLeaveRequestRequest $request, $id)
    {
 
        $leaveRequest = LeaveRequest::find($id);
        
         if (empty($leaveRequest)) {
           return $this->sendErrorResponse(['Invalid LeaveREquest does not exist']);
        }

        $leaveRequest->status = $request->status;
        $leaveRequest->save();

       return $this->sendSuccessMessage('Leave Request Successfully Updated');
    }

    public function store(StoreLeaveRequestRequest $request)
    {

        $leaveRequest = new LeaveRequest;
        $leaveRequest->user_id= auth()->id();
        $leaveRequest->title = $request->title;
        $leaveRequest->description = $request->description;
        $leaveRequest->start_date = $request->start_date;
        $leaveRequest->end_date = $request->end_date;
        $leaveRequest->save();

       return $this->sendSuccessMessage('Leave Request Successfully Saved');
       
    }
}
