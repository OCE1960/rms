<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkItemRequest;
use App\Http\Requests\UpdateWorkItemRequest;
use App\Models\WorkItem;

class WorkItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreWorkItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkItem $workItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkItem $workItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkItemRequest $request, WorkItem $workItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkItem $workItem)
    {
        //
    }
}
