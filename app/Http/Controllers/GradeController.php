<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGradesRequest;
use App\Http\Requests\UpdateGradesRequest;
use App\Models\Grade;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grades = Grade::orderBy('code')->get();
        return view('backend.grade-settings.index')->with('grades', $grades); 
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGradesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGradesRequest $request)
    {


        $grade = new Grade();
        $grade->label = $request->label;
        $grade->point = $request->point;
        $grade->code = $request->code;
        $grade->school_id = $request->school_id;
        $grade->lower_band_score = $request->lower_band_score;
        $grade->higher_band_score = $request->higher_band_score;
        $grade->save();

       return $this->sendSuccessMessage('grade Successfully Created');
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Grade $department, $id)
    {

        $grade = Grade::find($id);

        //Redirect to the Role page if validation fails.
         if (empty($grade)) { 
           return $this->sendErrorResponse(['Fees does not exist']);
        }

       $data = ['grade' => $grade];

       return $this->sendSuccessResponse('grade Record Successfully Retrived',$data);
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGradesRequest  $request
     * @param  \App\Models\grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGradesRequest $request, $id)
    {
        $grade = Grade::find($request->id);

        //Redirect to the Role page if validation fails.
        if (empty($grade)) { 
           return $this->sendErrorResponse(['Department does not exist']);
        }

        $grade->label = $request->label;
        $grade->code = $request->code;
        $grade->point = $request->point;
        $grade->school_id = $request->school_id;
        $grade->lower_band_score = $request->lower_band_score;
        $grade->higher_band_score = $request->higher_band_score;
        $grade->save();

       return $this->sendSuccessMessage('Fees Successfully Updated');
    }

    public function viewDetails(Grade $department, $id)
    {

        $grade = Grade::find($id);

        //Redirect to the Role page if validation fails.
         if (empty($grade)) { 
           return $this->sendErrorResponse(['Grade does not exist']);
        }

       $data = ['grade' => $grade];

       return $this->sendSuccessResponse('grade Record Successfully Retrived',$data);
       
    }
}
