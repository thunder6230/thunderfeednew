<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Picture;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PictureCommentReplied extends Mailable
{
    use Queueable, SerializesModels;

    public $user = "";
    public $picture = "";
    public function __construct(Picture $picture, User $user)
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
            'title' => 'Your have a new Reply!',
            'message' => $this->user->name . ' replied to your Comment. Click on the button to check it!',
            'buttonText' => 'Check Comment',
            'route' => 'profile.picture',
            'route_params' => [$this->picture->user->username, $this->picture->id]
        ]);
    }
}
