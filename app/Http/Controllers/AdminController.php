<?php

namespace App\Http\Controllers;

use App\ChatRoom;
use App\ChatMessage;
use Illuminate\Support\Facades\Auth;
use App\Events\NewChatMessage;
use App\Message;
use App\Room;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function rooms(Request $request)
    {
        return Room::with('user')->get();
    }
    public function messages(Request $request, $roomId)
    {
        return Message::where('room_id', $roomId)
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function newMessage(Request $request, $roomId)
    {
        $newMessage = new Message();
        $newMessage->user_id= Auth::id();
        $newMessage->room_id = $roomId;
        $newMessage->message = $request->message;
        $newMessage->save();
        broadcast(new NewChatMessage($newMessage))->toOthers();
        return response()->json($newMessage);
    }
}
