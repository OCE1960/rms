<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Feedback;
use App\Models\ResultVerificationRequest;
use App\Models\TranscriptRequest;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allFeedback = Feedback::orderBy('created_at', 'desc')->get();
        return view('feedback.index')->with('allFeedback', $allFeedback);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeedbackRequest $request)
    {
        $authUser = auth()->user();
        $transcriptRequest = TranscriptRequest::find($request->transcript_request_id);
        $resultVerificationRequest = ResultVerificationRequest::find($request->result_verification_request_id);
        $feedback = new Feedback();
        $feedback->transcript_request_id = $request->transcript_request_id;
        $feedback->comment_by = $authUser->id;
        $feedback->comment = $request->comment;
        $feedback->result_verification_request_id = $request->result_verification_request_id;
        $feedback->save();

        if (!is_null($transcriptRequest)) {
            $transcriptRequest->has_provided_feedback = true;
            $transcriptRequest->save();
        }

        if (!is_null($resultVerificationRequest)) {
            $resultVerificationRequest->has_provided_feedback = true;
            $resultVerificationRequest->save();
        }

       return $this->sendSuccessMessage('feedback Successfully Created');
    }
}
