<?php

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class PostNotification extends Component
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
        $this->text = Str::contains(Str::lower($notification->type), 'like') ? 'liked this Post!' : 'commented to this Post!';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.post-notification');
    }
}
