<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\TranscriptRequest;

class TranscriptRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $transcriptRequest;
    public $sender;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TranscriptRequest $transcriptRequest)
    {
        $this->transcriptRequest = $transcriptRequest;
        $this->sender = $transcriptRequest->requestedBy->full_name;
        $this->url = route('list.transcript-requests');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Transcript Request from " . $this->sender;
        return $this->subject($subject)
            ->markdown('mail.transcript-request');
    }
}
