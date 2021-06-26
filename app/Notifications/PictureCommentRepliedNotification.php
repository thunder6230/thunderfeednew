<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Picture;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PictureCommentRepliedNotification extends Notification
{
    use Queueable;

    public $picture;
    public $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Picture $picture, User $user)
    {
        $this->picture = $picture;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user' => $this->user,
            'picture' => $this->picture,
        ];
    }
}
