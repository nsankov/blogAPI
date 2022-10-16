<?php

namespace App\Listeners;

use App\Events\CreateComment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReplyToComment;
class SendReplyToComment
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CreateComment  $event
     * @return void
     */
    public function handle(CreateComment $event)
    {
      if($event->comment->parent_id){
          Mail::to($event->comment->parent->user->email)->queue(new ReplyToComment($event->comment));
      }
    }
}
