<?php

namespace App\Mail;

use App\Models\Post;
use App\Models\User;
use App\Models\Picture;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PictureLiked extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user = "";
    public $picture = "";
    public function __construct(Picture $picture, User $user)#
    {
        $this->picture = $picture;
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
            'title' => 'You have a new Like!',
            'message' => $this->user->name . ' liked your Picture. Click on the button to check it!',
            'buttonText' => 'Check Picture',

            'route' => 'profile.picture',
            'route_params' => [$this->picture->user->username, $this->picture->id]
        ]);
    }
}
