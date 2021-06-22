<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FriendAccepted extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $gender;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->gender = $this->user->gender == 'male' ? 'his' : 'her';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.email', [
            'title' => 'You have a new friend!',
            'message' => "{$this->user->name} accepted your friend request. Click on the button to check {$this->gender} profile!",
            'buttonText' => 'Check Profile',
            'route' => 'profile',
            'route_params' => $this->user->username
        ]);
    }
}
