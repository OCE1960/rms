<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ResultVerifierAccount extends Mailable
{
    use Queueable, SerializesModels;
    public $full_name;
    public $route;
    public $code;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->full_name = $user->full_name;
        $this->code = $user->id;
        $this->route = route('verify.result.activate');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->markdown('mail.result-verifier-account');
        $subject = "Result Verification Account from  ".config('app.name');
        return $this->subject($subject)
                ->markdown('mail.result-verifier-account');
    }
}
