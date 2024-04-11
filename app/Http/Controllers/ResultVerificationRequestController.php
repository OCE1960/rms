<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAsignVerificationRequest;
use App\Mail\MoveFile;
use App\Models\Comment;
use App\Models\User;
use App\Models\TaskAssignment;
use App\Models\ResultVerificationRequest;
use App\Models\WorkItem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ResultVerificationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $verificationRequests = ResultVerificationRequest::orderBy('created_at', 'DESC')->get();

        return view('verification-requests.index')->with('verificationRequests', $verificationRequests);
    }

    public function show($id)
    {

        $verificationRequest = ResultVerificationRequest::find($id);

        //Redirect to the Role page if validation fails.
         if (empty($verificationRequest)) {
           return $this->sendErrorResponse(['Transcript Request does not exist']);
        }

        $staffs = User::where('school_id', $verificationRequest->school_id)->where('is_staff', true)->get();

       $data = [
            'verificationRequest' => $verificationRequest,
            'user' => $verificationRequest->requestedBy,
            'staffs' => $staffs,
            'school' => $verificationRequest->school,
       ];

       return $this->sendSuccessResponse('Transcript Request Record Successfully Retrived',$data);

    }

    public function assignVerificationRequestFile(StoreAsignVerificationRequest $request)
    {

        DB::beginTransaction();
        try {
            $verificationRequest = ResultVerificationRequest::findOrfail($request->verificationRequestId);
            $workItem = new WorkItem();
            $workItem->result_verification_request_id = $verificationRequest->id;
            $workItem ->save();

            $authUser = auth()->user();
            $sendTo = User::find($request->send_to);

            $taskItem = new TaskAssignment();
            $taskItem->work_item_id = $workItem->id;
            $taskItem->send_by = $authUser->id;
            $taskItem->send_to =  $request->send_to;
            $taskItem->status = 're-assign';
            $taskItem->save();

            if ($request->comment) {
                $comment = new Comment();
                $comment->result_verification_request_id = $request->verificationRequestId;
                $comment->comment_by = $authUser->id;
                $comment->comment = $request->comment;
                $comment->save();
            }

            DB::commit();

            Mail::to($sendTo->email)->send(new MoveFile($taskItem));

            return $this->sendSuccessMessage('File Successfully Moved');
        } catch (\Exception | ModelNotFoundException $e) {

            DB::rollback();
            Log::emergency(['error' => $e->getMessage()]);
            return $this->sendErrorResponse(['Their was an error Moving this File '. $e->getMessage()]);
        }


    }
}
