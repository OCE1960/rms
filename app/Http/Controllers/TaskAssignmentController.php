<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskAssignmentRequest;
use App\Http\Requests\UpdateTaskAssignmentRequest;
use App\Models\TaskAssignment;

class TaskAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $assignTasks = auth()->user()->assignTasks()->activeTasks()->orderBy('created_at')->get();
        return view('tasks.index')->with('assignTasks', $assignTasks); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskAssignmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskAssignment $taskAssignment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskAssignment $taskAssignment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskAssignmentRequest $request, TaskAssignment $taskAssignment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskAssignment $taskAssignment)
    {
        //
    }
}
