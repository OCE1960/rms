<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAcademicResultRequest;
use App\Http\Requests\UpdateAcademicResultRequest;
use App\Models\AcademicResult;
use App\Models\Course;
use App\Models\Grade;
use App\Models\User;

class AcademicResultController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAcademicResultRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function processAddSemesterResult(StoreAcademicResultRequest $request)
    {
        $authUser = auth()->user();
        $user = User::find($request->user_id);
        $course = Course::where('id', $request->course_id)->firstOrFail();
        
        //Redirect to Compiled Result Modal.
        if (empty($user)) { 
            return $this->sendErrorResponse(['User does not exist']);
        }

        $academicResult = new AcademicResult();
        $academicResult->course_id = $request->course_id;
        $academicResult->score = $request->score;
        $academicResult->created_by = $authUser->id;
        $academicResult->grade = $request->grade;
        $academicResult->user_id = $request->user_id;
        $academicResult->unit = $course->unit;
        $academicResult->grade_point = $course->unit * $request->grade_point;
        $academicResult->semester_id = $request->semester_id;
        $academicResult->save();

        return $this->sendSuccessMessage('Semester Result Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AcademicResult  $academicResult
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $academicResult = AcademicResult::find($id);
        $schoolId = $academicResult->user->school_id;

        //Redirect to the Role page if validation fails.
         if (empty($academicResult)) { 
           return $this->sendErrorResponse(['Semester Result does not exist']);
        }

        $grade = Grade::where('school_id', $schoolId)->where('code', $academicResult->grade)->first();

       $data = [
            'academicResult' => $academicResult,
            'grade' => $grade
        ];

       return $this->sendSuccessResponse('Semester Result Record Successfully Retrived',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAcademicResultRequest  $request
     * @param  \App\Models\AcademicResult  $academicResult
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAcademicResultRequest $request, $id)
    {
        $academicResult = AcademicResult::find($id);
        $authUser = auth()->user();
        $course = Course::where('id', $request->course_id)->firstOrFail();

        //Redirect to the Role page if validation fails.
         if (empty($academicResult)) { 
           return $this->sendErrorResponse(['Semester Result does not exist']);
        }

        $academicResult->course_id = $request->course_id;
        $academicResult->score = $request->score;
        $academicResult->created_by = $authUser->id;
        $academicResult->grade = $request->grade;
        $academicResult->user_id = $request->user_id;
        $academicResult->grade_point = $course->unit * $request->grade_point;
        $academicResult->semester_id = $request->semester_id;
        $academicResult->save();

        return $this->sendSuccessMessage('Semester Result Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AcademicResult  $academicResult
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $academicResult = AcademicResult::find($id);

        if (empty($academicResult)) { 
            return $this->sendErrorResponse(['Semester Result deleted successfully']);
         }
 
         $academicResult->delete();
 
         return $this->sendSuccessMessage('Semester Result Successfully deleted');
    }
}
