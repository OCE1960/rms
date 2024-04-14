<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\ResultVerificationRequest;
use App\Models\TranscriptRequest;

class DispatchMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transcriptRequest;
    public $resultVerificationRequest;
    public $sender;
    public $sendRequest;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(?TranscriptRequest $transcriptRequest, ?ResultVerificationRequest $resultVerificationRequest)
    {
        $this->transcriptRequest = $transcriptRequest;
        $this->resultVerificationRequest = $resultVerificationRequest;
        $this->sender =  ($transcriptRequest) ? $transcriptRequest->requestedBy->full_name : $resultVerificationRequest->requestedBy->full_name;
        $this->sendRequest = ($transcriptRequest) ? 'Transcript Request' : 'Result Verification Request';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Dispatch Notification for " . $this->sendRequest;
        return $this->subject($subject)
            ->markdown('mail.dispatch');
    }
}
