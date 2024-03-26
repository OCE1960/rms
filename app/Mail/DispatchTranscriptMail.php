<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Http\Requests\DispatchTranscriptRequest;

class DispatchTranscriptMail extends Mailable
{
    use Queueable, SerializesModels;
    public $full_name;
    public $registration_no;
    public $file_path;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(DispatchTranscriptRequest $request)
    {
        $this->full_name = $request->full_name;
        $this->registration_no = $request->registration_no;
        $this->file_path = $request->file_path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Transcript from ".config('app.name');
        return $this->subject($subject)
                ->markdown('mail.dispatch_transcript_markdown')
                ->attach(public_path($this->file_path), [
                    'as' => 'Student-Transcript.pdf',
                    'mime' => 'application/pdf',
                ]);
    }
}
