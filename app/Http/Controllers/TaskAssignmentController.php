<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskAssignmentRequest;
use App\Http\Requests\UpdateTaskAssignmentRequest;
use App\Models\Grade;
use App\Models\TaskAssignment;
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
        $grades = Grade::get();

        if ($request->has('in') && ($request->query('in'))) {
            $workItemId = $request->query('in');
            
            $selectedTask = TaskAssignment::where('id',$workItemId)->where('send_to', $authUser->id)
                ->activeTasks()->first();
        }
        return view('tasks.index')->with('assignTasks', $assignTasks)
            ->with('selectedTask', $selectedTask)
            ->with('viewStatus', $viewStatus)
            ->with('grades', $grades); 
    }

    public function viewTask(TaskAssignment $taskAssignment, $id)
    {

    }
}
