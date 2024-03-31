<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAsignTranscriptRequest;
use App\Mail\MoveFile;
use App\Models\Comment;
use App\Models\User;
use App\Models\TaskAssignment;
use App\Models\TranscriptRequest;
use App\Models\WorkItem;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TranscriptRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transcriptRequests = TranscriptRequest::orderBy('created_at', 'DESC')->get();

        return view('transcript-requests.index')->with('transcriptRequests', $transcriptRequests);
    }

    public function show($id)
    {

        $transcriptRequest = TranscriptRequest::find($id);

        //Redirect to the Role page if validation fails.
         if (empty($transcriptRequest)) { 
           return $this->sendErrorResponse(['Transcript Request does not exist']);
        }

        $staffs = User::where('school_id', $transcriptRequest->school_id)->get();

       $data = [
            'transcriptRequest' => $transcriptRequest,
            'user' => $transcriptRequest->requestedBy,
            'staffs' => $staffs,
            'school' => $transcriptRequest->school,
       ];

       return $this->sendSuccessResponse('Transcript Request Record Successfully Retrived',$data);
       
    }

    public function assignTranscriptRequestFile(StoreAsignTranscriptRequest $request)
    {

        DB::beginTransaction();
        try {
            $transcriptRequest = TranscriptRequest::findOrfail($request->transcriptRequestId);
            $workItem = new WorkItem();
            $workItem->transcript_request_id = $transcriptRequest->id;
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
                $comment->transcript_request_id = $request->transcriptRequestId;
                // $comment->result_verification_request_id = $request->verifyResultRequestId;
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
