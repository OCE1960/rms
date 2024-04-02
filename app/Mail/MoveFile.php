<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\TaskAssignment;

class MoveFile extends Mailable
{
    use Queueable, SerializesModels;

    public $taskItem;
    public $sender;
    public $sendTo;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TaskAssignment $taskItem)
    {
        $this->taskItem = $taskItem;
        $this->sender = $taskItem->sendBy->full_name;
        $this->sendTo = $taskItem->sendTo->full_name;
        $this->url = route('tasks',"in=".$taskItem->id);
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
