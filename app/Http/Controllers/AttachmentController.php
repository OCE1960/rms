<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use Illuminate\Support\Facades\File;
use Mpdf\Mpdf;

class AttachmentController extends Controller
{
    public static function generateTranscriptResult($transcriptRequest, $template)
    {

        $authUser = auth()->user();
        $mpdf = new Mpdf(['tempDir'=>storage_path('tempdir')]);
        $mpdf->SetWatermarkText('Student Copy');
        $mpdf->showWatermarkText = true;
        $mpdf->setFooter('{PAGENO}');
        $mpdf->WriteHTML($template);
        $time_now = time();
        $transcriptFilePathStudentCopy = storage_path("app/public/transcripts/result-student-{$time_now}");
        $mpdf->Output($transcriptFilePathStudentCopy, 'F');

        $mpdf = new Mpdf(['tempDir'=>storage_path('tempdir')]);
        $mpdf->SetWatermarkText('Original Copy');
        $mpdf->showWatermarkText = true;
        $mpdf->setFooter('{PAGENO}');
        $mpdf->WriteHTML($template);
        $time_now = time();
        $transcriptFilePath = storage_path("app/public/transcripts/result-{$time_now}");
        $mpdf->Output($transcriptFilePath, 'F');


        if ($transcriptFilePath && $transcriptFilePathStudentCopy) {
            $transcriptFileName = $time_now.'.pdf';
            $path = File::move($transcriptFilePath, public_path('transcripts').'/'.$transcriptFileName);
            $attachment = new Attachment();
            $attachment->file_path = "transcripts/{$transcriptFileName}";
            $attachment->created_by = $authUser->id;
            $attachment->label = 'Result Transcript';
            $attachment->description = "This Document contains the original Copy of the Student Transcript";
            $attachment->file_type =  "pdf";
            $attachment->requester_user_id =  $transcriptRequest->user_id;
            $attachment->transcript_request_id =  $transcriptRequest->id;
            $attachment->save();

            $transcriptFileName = 'student-'.$time_now.'.pdf';
            $path = File::move($transcriptFilePathStudentCopy, public_path('transcripts').'/'.$transcriptFileName);
            $attachment = new Attachment();
            $attachment->file_path = "transcripts/{$transcriptFileName}";
            $attachment->created_by = $authUser->id;
            $attachment->label = 'Student Copy Result Transcript';
            $attachment->description = "This Document contains the Student copy of the Result Transcript";
            $attachment->file_type =  "pdf";
            $attachment->is_student_copy =  true;
            $attachment->requester_user_id =  $transcriptRequest->user_id;
            $attachment->transcript_request_id =  $transcriptRequest->id;
            $attachment->save();

            return true;


        }
        return false;
        // $mpdf->Output();
    }

    public static function generateVerifyResult($verifyResultRequest, $template, $response)
    {
        $authUser = auth()->user();
        $mpdf = new Mpdf();
        $mpdf->SetWatermarkText('Verify Result Response');
        $mpdf->showWatermarkText = true;
        $mpdf->setFooter('{PAGENO}');
        $mpdf->WriteHTML($template);
        $time_now = time();
        $verifyResultFilePath = storage_path("app/public/verify-results/response-{$time_now}");
        $mpdf->Output($verifyResultFilePath, 'F');


        if ($verifyResultFilePath) {
            $verifyResultFileName = $time_now.'.pdf';
            $path = File::move($verifyResultFilePath, public_path('verify-results').'/'.$verifyResultFileName);
            $attachment = new Attachment();
            $attachment->file_path = "verify-results/{$verifyResultFileName}";
            $attachment->created_by = $authUser->id;
            $attachment->label = 'Result Verification';
            $attachment->description = $response;
            $attachment->file_type =  "pdf";
            $attachment->requester_user_id =  $verifyResultRequest->verifier_user_id;
            $attachment->verify_result_request_id =  $verifyResultRequest->id;
            $attachment->save();

            return true;


        }
        return false;
    }
}