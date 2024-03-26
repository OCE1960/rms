<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\WorkItem;

class MoveFile extends Mailable
{
    use Queueable, SerializesModels;

    public $workItem;
    public $sender;
    public $sendTo;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(WorkItem $workItem)
    {
        $this->workItem = $workItem;
        $this->sender = $workItem->sender->full_name;
        $this->sendTo = $workItem->sendTo->full_name;
        $this->url = route('assign-tasks',"in=".$workItem->id);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "Task Assignment from ".config('app.name');
        return $this->subject($subject)
            ->markdown('mail.move_file');
    }
}
