<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notification;

class NotificationsController extends Controller
{
    public function update(Request $request){
        $id = $request->notification_id;
        return response()->json(Notification::where('id', $id));
    }
    public function destroy(Request $request){

    }
}
