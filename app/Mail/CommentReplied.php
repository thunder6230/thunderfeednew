<?php

namespace App\Mail;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentReplied extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user = "";
    public $post = "";
    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->markdown('emails.email', [
            'title' => 'Your have a new Reply!',
            'message' => $this->user->name . ' replied to your Comment. Click on the button to check it!',
            'buttonText' => 'Check Comment',
            'route' => 'posts.show',
            'route_params' => [$this->post->id]
        ]);
    }
}
