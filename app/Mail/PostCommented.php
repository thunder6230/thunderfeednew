<?php

namespace App\Mail;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostCommented extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     * 
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
            'title' => 'Your Post has a new comment!',
            'message' => $this->user->name . ' commented to your Post. Click on the button to check it!',
            'buttonText' => 'Check Post',
            'route' => 'posts.show',
            'route_params' => [$this->post->id]
        ]);
    }
}
