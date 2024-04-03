<?php

namespace App\Http\Controllers;

use App\Http\Requests\BulkUploadRequest;
use App\Http\Requests\StoreSemesterRequest;
use App\Http\Requests\UpdateSemesterRequest;
use App\Models\Semester;
use Illuminate\Support\Facades\File;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authUser = auth()->user();
        $semesters = Semester::where('school_id', $authUser->school_id)
            ->orderBy('semester_session', 'asc')->orderBy('semester_name', 'asc')->get();

        return view('semesters.index')->with('semesters', $semesters)
            ->with('schoolId', $authUser->school_id); 
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSemesterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function processAddSemester(StoreSemesterRequest $request)
    {
        $authUser = auth()->user();

        $semester = new Semester();
        $semester->semester_session = $request->semester_session;
        $semester->school_id = $authUser->school_id;
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

    public function processSemesterBulkUpload(BulkUploadRequest $request)
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
                    $invalids = $this->validateSemesterValues($data, $authUser->school_id);
                  if (count($invalids) > 0) {
                    array_push($errors, $invalids);
                    continue;
                  }else{

                    Semester::updateOrCreate(
                        [
                            'semester_session' => trim($data[0]),
                            'school_id' => $authUser->school_id,
                            'semester_name' => trim($data[1]),
                        ], 
                        [
                            'updated_by' => $authUser->id,       
                        ]
                    );
                  }
                }else{
                    $headers = explode(',', $line);
                    if (trim(strtolower($headers[0])) != 'semester_session') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "semester_session,semester_name"';
                        array_push($errors, $invalids);
                        break;
                    }

                    if (trim(strtolower($headers[1])) != 'semester_name') {
                        $invalids['inc'] = 'The file format is incorrect. Must be - "semester_session,semester_name"';
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

    public function validateSemesterValues($data, $schoolId)
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
