<?php

namespace App\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class NavNotification extends Component
{
    public $notification;
    public $text;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
        if (Str::contains(Str::lower($notification->type), 'like')) {
            $this->text = 'liked this Post!';
        } else if (Str::contains(Str::lower($notification->type), 'comment')){
            
            $this->text = 'commented to this Post!';
        } else{
            if($notification->data['type'] == "requested"){
                $this->text = 'wants to be your friend!';
            } else {
                $this->text = 'accepted your request!';
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.nav-notification');
    }
}
