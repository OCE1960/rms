<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Models\School;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::orderBy('full_name', 'asc')->get();

        return view('school.index')->with('schools', $schools); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchoolRequest $request)
    {
        $school = new School();
        $school->full_name = $request->full_name;
        $school->short_name = $request->short_name;
        $school->address_street = $request->address_street;
        $school->address_mailbox = $request->address_mailbox;
        $school->address_town = $request->address_town;
        $school->state = $request->state;
        $school->geo_zone = $request->geo_zone;
        $school->type = $request->type;
        $school->official_phone = $request->official_phone;
        $school->official_email = $request->official_email;
        $school->official_website = $request->official_website;
        $school->save();

        return $this->sendSuccessMessage('School sucessfully Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $school = School::find($id);

        
         if (empty($school)) { 
           return $this->sendErrorResponse(['School does not exist']);
        }

       $data = [
            'school' => $school,
       ];

       return $this->sendSuccessResponse('School Record Successfully Retrived',$data);
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchoolRequest $request, $id)
    {
        $school = School::find($id);

        //Redirect to the Role page if validation fails.
         if (empty($school)) { 
           return $this->sendErrorResponse(['School Record does not exist']);
        }

        $school->full_name = $request->full_name;
        $school->short_name = $request->short_name;
        $school->address_street = $request->address_street;
        $school->address_mailbox = $request->address_mailbox;
        $school->address_town = $request->address_town;
        $school->state = $request->state;
        $school->geo_zone = $request->geo_zone;
        $school->type = $request->type;
        $school->official_phone = $request->official_phone;
        $school->official_email = $request->official_email;
        $school->official_website = $request->official_website;
        $school->save();

        return $this->sendSuccessMessage('Semester Result Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        //
    }
}
