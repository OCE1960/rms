<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ResultVerificationRequest;

class ResultVerificationRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resultVerificationRequest;
    public $sender;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ResultVerificationRequest $resultVerificationRequest)
    {
        $this->resultVerificationRequest = $resultVerificationRequest;
        $this->sender = $resultVerificationRequest->requestedBy->full_name;
        $this->url = route('verification-requests');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Result Verification Request from " . $this->sender;
        return $this->subject($subject)
            ->markdown('mail.result-verification-request');
    }
}
