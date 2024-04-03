<?php

namespace App\Http\Controllers;

use App\Http\Requests\BulkUploadRequest;
use App\Http\Requests\StoreCoursesRequest;
use App\Http\Requests\UpdateCoursesRequest;
use App\Models\Course;
use Illuminate\Support\Facades\File;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authUser = auth()->user();
        $courses = Course::where('school_id', $authUser->school_id)
            ->orderBy('course_code', 'asc')->orderBy('course_name', 'asc')->get();

        return view('courses.index')->with('courses', $courses); 
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCoursesRequest $request)
    {
        $authUser = auth()->user();
        Course::updateOrCreate(
            [
                'course_code' => $request->course_code,
            ], 
            [
                'course_name' => $request->course_name,
                'unit' => $request->unit,
                'school_id' => $authUser->school_id,       
            ]
        );
        
        return $this->sendSuccessMessage('Student sucessfully Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $course = Course::find($id);

        
         if (empty($course)) { 
           return $this->sendErrorResponse(['Course does not exist']);
        }

       $data = [
            'course' => $course,
       ];

       return $this->sendSuccessResponse('Course Record Successfully Retrived',$data);
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCoursesRequest $request, $id)
    {
        $course = Course::find($id);

        //Redirect to the Role page if validation fails.
         if (empty($course)) { 
           return $this->sendErrorResponse(['Course Record does not exist']);
        }

        $authUser = auth()->user();
        Course::updateOrCreate(
            [
                'course_code' => $request->course_code,
            ], 
            [
                'course_name' => $request->course_name,
                'unit' => $request->unit,
                'school_id' => $authUser->school_id,       
            ]
        );

        return $this->sendSuccessMessage('Course Result Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::find($id);

        //Redirect to the Role page if validation fails.
         if (empty($course)) { 
           return $this->sendErrorResponse(['Course record does not exists']);
        }

        $course->delete();

        return $this->sendSuccessMessage('Course Successfully deleted');
    }

    public function processCourseBulkUpload(BulkUploadRequest $request)
    {
      $filePath = $this->storeFile($request, 'bulk_upload_file');
      $authUser = auth()->user();
       $errors = [];
        $loop = 1;
        $lines = file($filePath);
        if (count($lines) > 1) {
            foreach ($lines as $line) {
                // skip first line (heading line)
                if ($loop > 1) {
                    $data = explode(',', $line);
                    // dd($data);
                    $invalids = $this->validateCourseValues($data);
                  if (count($invalids) > 0) {
                    array_push($errors, $invalids);
                    continue;
                  }else{

                    Course::updateOrCreate(
                        [
                            'course_code' => trim($data[0]),
                        ], 
                        [
                            'course_name' => trim($data[1]),
                            'unit' => trim($data[2]),
                            'school_id' => $authUser->school_id,       
                        ]
                    );
                  }
                }else{
                    $headers = explode(',', $line);
                    if (trim(strtolower($headers[0])) != 'course_code') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "course_code,course_name,course_unit"';
                        array_push($errors, $invalids);
                        break;
                    }

                    if (trim(strtolower($headers[1])) != 'course_name') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "course_code,course_name,course_unit"';
                        array_push($errors, $invalids);
                        break;
                    }

                    if (trim(strtolower($headers[2])) != 'course_unit') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "course_code,course_name,course_unit"';
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

    public function validateCourseValues($data)
    {
        $errors = [];
         
     

        // $courseCode =Course::where('course_code', $data[0])->where('course_name', '<>', $data[1])->first();
        // if ($courseCode) {
        //     $errors[] = 'The Course Code: '.$data[0].' already exist';
        // }
        
        // $courseName =Course::where('course_name', $data[1])->where('course_code', '<>', $data[0])->first();
        // if ($courseName) {
        //     $errors[] = 'The Course Name: '.$data[1].' already exist';
        // } 


        return $errors;
    }
}
