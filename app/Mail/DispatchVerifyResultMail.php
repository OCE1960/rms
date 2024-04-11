<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ResultVerificationRequest;

class DispatchVerifyResultMail extends Mailable
{
    use Queueable, SerializesModels;
    public $full_name;
    public $receiver;
    public $registration_no;
    public $file_path;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ResultVerificationRequest $verifyResultRequest)
    {
        $this->full_name = $verifyResultRequest->student_first_name.' '.$verifyResultRequest->student_middle_name.' '.$verifyResultRequest->student_last_name;
        $this->receiver = $verifyResultRequest->requestedBy->full_name;
        $this->registration_no = $verifyResultRequest->registration_no;
        $this->file_path = $verifyResultRequest->resultVerificationResponseAttachment() ? $verifyResultRequest->resultVerificationResponseAttachment()->file_path : "";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Result Verification from ".config('app.name');
        return $this->subject($subject)->markdown('mail.dispatch_verify_result')
            ->attach(public_path($this->file_path), [
                'as' => 'Result-Verification-Response.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
