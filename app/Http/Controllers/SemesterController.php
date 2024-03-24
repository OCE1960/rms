<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;
use App\Models\Semester;
use App\Models\User;

class SemesterController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSemesterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function processAddSemester(StoreSemesterRequest $request)
    {
        $authUser = auth()->user();
        $user = User::find($request->user_id);
        
        //Redirect to Compiled Result Modal.
        if (empty($user)) { 
            return $this->sendErrorResponse(['User does not exist']);
        }

        $semester = new Semester();
        $semester->semester_session = $request->semester_session;
        $semester->school_id = $request->school_id;
        $semester->created_by = $authUser->id;
        $semester->semester_name = $request->semester_name;
        $semester->save();

        return $this->sendSuccessMessage('Semester Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $semester = Semester::find($id);

        //Redirect to the Role page if validation fails.
         if (empty($semester)) { 
           return $this->sendErrorResponse(['Semester does not exist']);
        }

       $data = ['semester' => $semester];

       return $this->sendSuccessResponse('Semester Record Successfully Retrived',$data);
       
    }

    public function update(UpdateSemesterRequest $request, $id)
    {
        //dd($request);
        $semester = Semester::find($id);
        $authUser = auth()->user();

        //Redirect to the Role page if validation fails.
         if (empty($semester)) { 
           return $this->sendErrorResponse(['Semester does not exist']);
        }


        $semester->semester_session = $request->semester_session;
        $semester->created_by = $authUser->id;
        $semester->semester_name = $request->semester_name;
        $semester->save();

        return $this->sendSuccessMessage('Semester Successfully Updated');
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $semester = Semester::find($id);

        //Redirect to the Role page if validation fails.
         if (empty($semester)) { 
           return $this->sendErrorResponse(['Semester deleted']);
        }

        $semester->delete();

        return $this->sendSuccessMessage('Semester Successfully deleted');
    }
}
