<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompileTranscriptRequest;
use App\Models\Grade;
use App\Models\Student;
use App\Models\TaskAssignment;
use App\Models\TranscriptRequest;
use App\Models\User;
use Illuminate\Http\Request;

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

        if ($request->has('in') && ($request->query('in'))) {
            $workItemId = $request->query('in');
            $grades = Grade::get();
            
            $selectedTask = TaskAssignment::where('id',$workItemId)->where('send_to', $authUser->id)
                ->activeTasks()->firstOrFail();

            $grades = Grade::where('school_id', $selectedTask->school_id)->get();
        }
        return view('tasks.index')->with('assignTasks', $assignTasks)
            ->with('selectedTask', $selectedTask)
            ->with('viewStatus', $viewStatus)
            ->with('grades', $grades); 
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
}
