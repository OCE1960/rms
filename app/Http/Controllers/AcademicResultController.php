<?php

namespace App\Http\Controllers;

use App\Http\Requests\BulkUploadResultRequest;
use App\Http\Requests\StoreAcademicResultRequest;
use App\Http\Requests\UpdateAcademicResultRequest;
use App\Models\AcademicResult;
use App\Models\Course;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Support\Facades\File;

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

    public function processAcademicResultBulkUpload(BulkUploadResultRequest $request)
    {
      $filePath = $this->storeFile($request, 'bulk_upload_file');
      $authUser = auth()->user();
      $semesterId = $request->academic_session;
      $grades = Grade::where('school_id', $authUser->school_id)->orderBy('lower_band_score', 'desc')->get();
       $errors = [];
        $loop = 1;
        $lines = file($filePath);
        if (count($lines) > 1) {
            foreach ($lines as $line) {
                // skip first line (heading line)
                if ($loop > 1) {
                    $data = explode(',', $line);
                    // dd($data);
                    $invalids = $this->validateResultValues($data, $authUser, $semesterId);
                  if (count($invalids) > 0) {
                    array_push($errors, $invalids);
                    continue;
                  }else{

                    $score = (int)trim($data[2]);
                    $course = Course::where('course_code', $data[1])->where('school_id', $authUser->school_id)->first();
                    $user = User::where('registration_no', $data[0])->where('school_id', $authUser->school_id)->where('is_student', true)->first();
                    $grade = null;
                    foreach ($grades as $academicGrade) {
                        if ( ($score >= $academicGrade->lower_band_score) && ($score <= $academicGrade->higher_band_score) ) {
                            $grade = $academicGrade;
                            break;
                        }
                    }
                    //$grade = $grades->where('lower_band_score', '>=', $data[2])->first();
                    $gradePoint = $course->unit * $grade?->point;

                    AcademicResult::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'semester_id' => $semesterId,
                            'course_id' => $course->id,
                        ],
                        [
                            'score' =>trim($data[2]),
                            'created_by' => $authUser->id,
                            'grade' => $grade?->code,
                            'unit' => $course->unit,
                            'grade_point' => $gradePoint,
                            'updated_by' => $authUser->id,
                        ]
                    );
                  }
                }else{
                    $headers = explode(',', $line);
                    if (trim(strtolower($headers[0])) != 'registration_no') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "registration_no,course_code,score"';
                        array_push($errors, $invalids);
                        break;
                    }

                    if (trim(strtolower($headers[1])) != 'course_code') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "registration_no,course_code,score"';
                        array_push($errors, $invalids);
                        break;
                    }

                    if (trim(strtolower($headers[2])) != 'score') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "registration_no,course_code,score"';
                        array_push($errors, $invalids);
                        break;
                    }
                }
                $loop++;
            }
        }else{
            $errors[] = 'The uploaded csv file is empty';
        }

        File::delete($filePath);

        if (count($errors) > 0) {
            $collectErrors = $this->array_flatten($errors);

            return $this->sendErrorResponse($collectErrors);
        }

        return $this->sendSuccessMessage('Student Bulk Upload Successful');
    }

    public function validateResultValues($data, $authUser, $semesterId)
    {
        $errors = [];

        $course = Course::where('course_code', $data[1])->where('school_id', $authUser->school_id)->first();
        if (is_null($course)) {
            $errors[] = 'The course_code: '.$data[1].' does not exist';
        }

        // validate matric number
        $registration_no = User::where('registration_no', $data[0])->where('school_id', $authUser->school_id)->where('is_student', true)->first();
        if (is_null($registration_no)) {
            $errors[] = 'The Registration no: '.$data[0].' does not exist';
        }

        return $errors;
    }
}
