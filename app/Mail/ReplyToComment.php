<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Comment;

class ReplyToComment extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(private Comment $comment)
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.comment.reply', [
          'name' => $this->comment->parent->user->name,
          'comment' => $this->comment->parent->content,
          'reply_from' => $this->comment->user->name,
          'reply_content' => $this->comment->content,
        ]);
    }
}
