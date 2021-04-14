<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\View\Component;

class FriendRequest extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $notification;
    public $text;
    public function __construct($notification)
    {
        $this->notification = $notification;
        $this->text = $notification->data['type'] == "requested" ? "sent you a Friendrequest!" : "accepted your Friendrequest";
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.friend-request');
    }
}
