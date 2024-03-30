<?php

namespace App\Http\Controllers;

use App\Http\Requests\DispatchTranscriptRequest ;
use App\Http\Requests\StoreCompileTranscriptRequest;
use App\Http\Requests\StoreDecisionRequest;
use App\Http\Requests\StoreDispatchRequest;
use App\Http\Requests\StoreMoveFileRequest;
use App\Mail\DispatchTranscriptMail;
use App\Mail\DispatchVerifyResultMail;
use App\Mail\MoveFile;
use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Course;
use App\Models\Grade;
use App\Models\ResultVerificationRequest;
use App\Models\Role;
use App\Models\Student;
use App\Models\TaskAssignment;
use App\Models\TranscriptRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TaskAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $viewStatus = "in";
        $authUser = auth()->user();
        $selectedTask = null;
        $assignTasks = auth()->user()->assignTasks()->activeTasks()->orderBy('created_at')->paginate(10);
        $grades = null;
        $courses = null;
        $users = null;
        $admin = Role::where('key', 'super-admin')->firstOrFail();
        $registry = Role::where('key', 'registry')->firstOrFail();

        if ($request->has('in') && ($request->query('in'))) {
            $workItemId = $request->query('in');
            $item = $request->input('item');
            $schoolId = $selectedTask;
            
            $selectedTask = TaskAssignment::where('id',$workItemId)->where('send_to', $authUser->id)
                ->activeTasks()->firstOrFail();

            $workItem = $selectedTask->workItem;

            $taskItemMorph = $workItem->transcript_request_id ? $workItem->transcriptRequest : $workItem->resultVerificationRequest;
            $grades = Grade::where('school_id', $taskItemMorph->school_id)->get();
            $courses = Course::where('school_id', $taskItemMorph->school_id)->get();

            if ($authUser->hasRole($admin->id) || $authUser->hasRole($registry->id)) {
                $users = User::where('is_staff', true)->where('school_id', $taskItemMorph->school_id)->get();
            } else {
                $users = User::where('is_staff', true)
                    ->where('school_id', $authUser->school_id)->get();
            }
        }

        if ($request->has('out')) {
            $workItemId = $request->query('out');
            $viewStatus = "out";
            $selectedTask = TaskAssignment::where('id',$workItemId)->where('send_to', $authUser->id)
                            ->where('is_task_completed', true)->first();
            
            $assignTasks = TaskAssignment::where('send_to', $authUser->id)->where('is_task_completed', true)->where('id', '<>', $workItemId)
                ->paginate(10)->unique('work_item_id'); 

            // $assignTasks = $workItems->unique(function ($item) {
            //     return $item['work_item_id'];
            // });

        }


        return view('tasks.index')->with('assignTasks', $assignTasks)
            ->with('selectedTask', $selectedTask)
            ->with('viewStatus', $viewStatus)
            ->with('courses', $courses)
            ->with('users', $users)
            ->with('grades', $grades); 
    }

    public function processMoveFile(StoreMoveFileRequest $request)
    {

        DB::beginTransaction();

        try {
            $oldTaskItem = TaskAssignment::find($request->taskItemId);
            $authUser = auth()->user();
            $sendTo = User::find($request->send_to);
            $taskItem = new TaskAssignment();
            $taskItem->work_item_id = $request->workItemId;
            $taskItem->send_by = $authUser->id;
            $taskItem->send_to =  $request->send_to; 
            $taskItem->status = 're-assign'; 
            $taskItem->save();

            if ($request->comment) {
                $comment = new Comment();
                $comment->transcript_request_id = $request->transcriptRequestId;
                $comment->result_verification_request_id = $request->verifyResultRequestId;
                $comment->comment_by = $authUser->id;
                $comment->comment = $request->comment;
                $comment->save();
            }

            $oldTaskItem->is_task_completed = true;
            $oldTaskItem->save();

            DB::commit();

            Mail::to($sendTo->email)->send(new MoveFile($taskItem));

            return $this->sendSuccessMessage('File Successfully Moved');
        } catch (\Exception $e) {

            DB::rollback();
            Log::emergency(['error' => $e->getMessage()]);
            return $this->sendErrorResponse(['Their was an error Moving this File '. $e->getMessage()]);
        }

        
    }


    public function processCompileResult(StoreCompileTranscriptRequest $request)
    {
        $authUser = auth()->user();
        $user = User::find($request->user_id);
        $transcriptRequest = TranscriptRequest::find($request->transcriptRequestId);


        //Redirect to Compiled Result Modal.
        if (empty($user)) { 
            return $this->sendErrorResponse(['User does not exist']);
        }

        //Redirect to Compiled Result Modal.
        if (empty($transcriptRequest )) { 
            return $this->sendErrorResponse(['Transcript Request does not exist']);
        }

        $student = Student::where('user_id', $user->id)->first();
        if ($student == null) {
            $student = new Student;
        }

        $user->gender = $request->gender;
        $user->date_of_birth = $request->date_of_birth;
        $user->nationality = $request->nationality;
        $user->state_of_origin = $request->state_of_origin;
        $user->save();

        $student->department = $request->department;
        $student->date_of_entry = $request->date_of_entry;
        $student->mode_of_entry = $request->mode_of_entry;
        $student->save();

        $transcriptRequest->is_result_compiled = true;
        $transcriptRequest->compiled_by = $authUser->id;
        $transcriptRequest->save();

        return $this->sendSuccessMessage('Compiled Result Successfully Created');
    }

    public function processCheckCompileResult(StoreDecisionRequest $request)
    {
        $authUser = auth()->user();
        $user = User::find($request->user_id);
        $transcriptRequest = TranscriptRequest::find($request->transcriptRequestId);


        //Redirect to Compiled Result Modal.
        if (empty($user)) { 
            return $this->sendErrorResponse(['User does not exist']);
        }

        //Redirect to Compiled Result Modal.
        if (empty($transcriptRequest )) { 
            return $this->sendErrorResponse(['Transcript Request does not exist']);
        }

        if ($request->comment) {
            $comment = new Comment();
            $comment->transcript_request_id = $transcriptRequest->id;
            $comment->comment_by = $authUser->id;
            $comment->comment = $request->comment;
            $comment->save();
        }

        $transcriptRequest->is_result_checked = $request->decision;
        $transcriptRequest->checked_by = $authUser->id;
        $transcriptRequest->save();

        return $this->sendSuccessMessage('Compiled Result Successfully Checked');
    }

    public function processRecommendCompileResult(StoreDecisionRequest $request)
    {
        $authUser = auth()->user();
        $user = User::find($request->user_id);
        $transcriptRequest = TranscriptRequest::find($request->transcriptRequestId);


        //Redirect to Compiled Result Modal.
        if (empty($user)) { 
            return $this->sendErrorResponse(['User does not exist']);
        }

        //Redirect to Compiled Result Modal.
        if (empty($transcriptRequest )) { 
            return $this->sendErrorResponse(['Transcript Request does not exist']);
        }

        if ($request->comment) {
            $comment = new Comment();
            $comment->transcript_request_id = $transcriptRequest->id;
            $comment->comment_by = $authUser->id;
            $comment->comment = $request->comment;
            $comment->save();
        }

        $transcriptRequest->is_result_recommended = $request->decision;
        $transcriptRequest->recommended_by = $authUser->id;
        $transcriptRequest->save();

        return $this->sendSuccessMessage('Compiled Result Successfully Recommended');
    }

    public function processApproveCompileResult(StoreDecisionRequest $request)
    {
        $authUser = auth()->user();
        $userRequestingTranscript = User::find($request->user_id);
        $transcriptRequest = TranscriptRequest::find($request->transcriptRequestId);


        //Redirect to Compiled Result Modal.
        if (empty($userRequestingTranscript)) { 
            return $this->sendErrorResponse(['User does not exist']);
        }

        //Redirect to Compiled Result Modal.
        if (empty($transcriptRequest )) { 
            return $this->sendErrorResponse(['Transcript Request does not exist']);
        }

        if ($request->comment) {
            $comment = new Comment();
            $comment->transcript_request_id = $transcriptRequest->id;
            $comment->comment_by = $authUser->id;
            $comment->comment = $request->comment;
            $comment->save();
        }

        $academicResults = $userRequestingTranscript->academicResults()->get()->groupBy('semester_id');
        

        $transcriptTemplate = view("templates.transcript")->with('userRequestingTranscript', $userRequestingTranscript)
            ->with('academicResults', $academicResults);

        $oldAttachments = Attachment::where('transcript_request_id', $transcriptRequest->id)->get();

        if (count($oldAttachments) > 0) {
            foreach ($oldAttachments as $oldAttachment) {
                if (($oldAttachment->file_path) && file_exists(public_path($oldAttachment->file_path))) {
                    unlink(public_path($oldAttachment->file_path));
                }
                $oldAttachment->delete();
            }
            
        }

        if ($request->decision) {
            $attachment = AttachmentController::generateTranscriptResult($transcriptRequest, $transcriptTemplate);
        }

        $transcriptRequest->is_result_approved = $request->decision;
        $transcriptRequest->approved_by = $authUser->id;
        $transcriptRequest->save();

        // if ($attachment) {

            $userRequestingTranscript->has_compiled_result = true;
            $userRequestingTranscript->save();

            return $this->sendSuccessMessage('Compiled Result Successfully Approved');
        // }

        // return $this->sendErrorResponse(['Their was an error generating the Transcript']);
        
    }

    public function processDispatchCompileResult(DispatchTranscriptRequest $request)
    {
        $authUser = auth()->user();
        $user = User::where('registration_no', $request->registration_no)->first();
        $transcriptRequest = TranscriptRequest::find($request->transcriptRequestId);


        //Redirect to Compiled Result Modal.
        if (empty($user)) { 
            return $this->sendErrorResponse(['User does not exist']);
        }

        //Redirect to Compiled Result Modal.
        if (empty($transcriptRequest )) { 
            return $this->sendErrorResponse(['Transcript Request does not exist']);
        }

        Mail::to($request->destination_email)->send(new DispatchTranscriptMail($request));

        if ($request->comment) {
            $comment = new Comment();
            $comment->transcript_request_id = $transcriptRequest->id;
            $comment->comment_by = $authUser->id;
            $comment->comment = $request->comment;
            $comment->save();
        }

        $transcriptRequest->is_result_dispatched= true;
        $transcriptRequest->dispatched_by = $authUser->id;
        $transcriptRequest->save();

        return $this->sendSuccessMessage('Compiled Result Successfully Dispatch');
    }


    public function processArchivedTrancriptRequest(StoreDecisionRequest $request)
    {
        $authUser = auth()->user();
        $user = User::find($request->user_id);
        $transcriptRequest = TranscriptRequest::find($request->transcriptRequestId);


        //Redirect to Compiled Result Modal.
        if (empty($user)) { 
            return $this->sendErrorResponse(['User does not exist']);
        }

        //Redirect to Compiled Result Modal.
        if (empty($transcriptRequest )) { 
            return $this->sendErrorResponse(['Transcript Request does not exist']);
        }

        $artifact_name = 'Archive-Transcript-Request';
        $taskManager = TaskManager::where('transcript_request_id', $transcriptRequest->id)
            ->where('artifact', $artifact_name)->first();
        
        if ($taskManager == null) {
            $taskManager = new TaskManager;
        }

        $taskManager->transcript_request_id = $transcriptRequest->id;
        $taskManager->created_by = $authUser->id;
        $taskManager->artifact = $artifact_name;
        $taskManager->save();

        if ($request->comment) {
            $comment = new Comment();
            $comment->transcript_request_id = $transcriptRequest->id;
            $comment->comment_by = $authUser->id;
            $comment->comment = $request->comment;
            $comment->save();
        }

        $transcriptRequest->is_archived = $request->decision;
        $transcriptRequest->archived_by = $authUser->id;
        $transcriptRequest->save();

        return $this->sendSuccessMessage('Compiled Result Successfully Dispatch');
    }
    
    public function processVerifyResult(StoreDecisionRequest $request)
    {
        $authUser = auth()->user();
        $verifyResultRequest = ResultVerificationRequest::find($request->verifyResultRequestId);

        if (empty($verifyResultRequest)) { 
            return $this->sendErrorResponse(['Verify Result Request does not exist']);
        }

        if ($request->comment) {
            $comment = new Comment();
            $comment->result_verification_request_id = $verifyResultRequest->id;
            $comment->comment_by = $authUser->id;
            $comment->comment = $request->comment;
            $comment->save();
        }

        $verifyResultRequest->is_result_verified = $request->decision;
        $verifyResultRequest->verified_by = $authUser->id;
        $verifyResultRequest->save();

        return $this->sendSuccessMessage('Verify Result Operation Successful');
    }

    public function processCheckVerifyResult(StoreDecisionRequest $request)
    {
        $authUser = auth()->user();
        $verifyResultRequest = ResultVerificationRequest::find($request->verifyResultRequestId);

        //Redirect to Compiled Result Modal.
        if (empty($verifyResultRequest)) { 
            return $this->sendErrorResponse(['Verify Result Request does not exist']);
        }

        if ($request->comment) {
            $comment = new Comment();
            $comment->result_verification_request_id  = $verifyResultRequest->id;
            $comment->comment_by = $authUser->id;
            $comment->comment = $request->comment;
            $comment->save();
        }

        $verifyResultRequest->is_result_checked = $request->decision;
        $verifyResultRequest->checked_by= $authUser->id;
        $verifyResultRequest->save();

        return $this->sendSuccessMessage('Check Verify Result Operation Successful');
    }

    public function processRecommendVerifyResult(StoreDecisionRequest $request)
    {
        $authUser = auth()->user();
        $verifyResultRequest = ResultVerificationRequest::find($request->verifyResultRequestId);

        //Redirect to Compiled Result Modal.
        if (empty($verifyResultRequest)) { 
            return $this->sendErrorResponse(['Verify Result Request does not exist']);
        }

        if ($request->comment) {
            $comment = new Comment();
            $comment->result_verification_request_id  = $verifyResultRequest->id;
            $comment->comment_by = $authUser->id;
            $comment->comment = $request->comment;
            $comment->save();
        }

        $verifyResultRequest->is_result_recommended = $request->decision;
        $verifyResultRequest->recommended_by= $authUser->id;
        $verifyResultRequest->save();

        return $this->sendSuccessMessage('Recommend Verify Result Operation Successful');
    }

    public function processApproveVerifyResult(StoreDecisionRequest $request)
    {
        $authUser = auth()->user();
        $verifyResultRequest = ResultVerificationRequest::find($request->verifyResultRequestId);

        //Redirect to Compiled Result Modal.
        if (empty($verifyResultRequest)) { 
            return $this->sendErrorResponse(['Verify Result Request does not exist']);
        }

        if ($request->comment) {
            $comment = new Comment();
            $comment->result_verification_request_id  = $verifyResultRequest->id;
            $comment->comment_by = $authUser->id;
            $comment->comment = $request->comment;
            $comment->save();
        }

        $verifyResultRequest->is_result_approved = $request->decision;
        $verifyResultRequest->approved_by= $authUser->id;
        $verifyResultRequest->save();

        return $this->sendSuccessMessage('Approve Verify Result Operation Successful');
    }

    public function processDispatchVerifyResult(StoreDispatchRequest $request)
    {
        $authUser = auth()->user();
        $verifyResultRequest = ResultVerificationRequest::find($request->verifyResultRequestId);

        //Redirect to Compiled Result Modal.
        if (empty($verifyResultRequest)) { 
            return $this->sendErrorResponse(['Verify Result Request does not exist']);
        }

        $response = $request->comment;
        $VerifyResultTemplate = view("templates.verify-result")
            ->with('verifyResultRequest', $verifyResultRequest)
            ->with('response', $response);

        $oldAttachments = Attachment::where('result_verification_request_id', $verifyResultRequest->id)
            ->where('label', 'Result Verification')->get();

       // dd($oldAttachments);
        if (count($oldAttachments) > 0) {
            foreach ($oldAttachments as $oldAttachment) {
                if (($oldAttachment->file_path) &&  file_exists(public_path($oldAttachment->file_path))) {
                    unlink(public_path($oldAttachment->file_path));
                }
                $oldAttachment->delete();
            }
            
        }

        $attachment = AttachmentController::generateVerifyResult($verifyResultRequest, $VerifyResultTemplate, $response);
      

        $verifyResultRequest->is_result_dispatched = true;
        $verifyResultRequest->dispatched_by= $authUser->id;
        $verifyResultRequest->save();


        $receiver = $verifyResultRequest->enquirer;

        Mail::to($receiver->email)->send(new DispatchVerifyResultMail($verifyResultRequest));

        return $this->sendSuccessMessage('Verify Result Dispatch Operation Successful');
    }
}
