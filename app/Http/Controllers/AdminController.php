<?php

namespace App\Http\Controllers;
use App\ChatRoom;
use App\ChatMessage;
use Illuminate\Support\Facades\Auth;
use App\Events\NewChatMessage;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function rooms(Request $request){
        $rooms =  ChatRoom::all();
        return response()->json($rooms);
    }
    public function messages(Request $request, $roomId){
        $messages = ChatMessage::where('chat_room_id', $roomId)
        ->with('user')
        ->orderBy('created_at', 'DESC')
        ->get();
        return response()->json($messages);
    }

    public function newMessage(Request $request, $roomId){
        $newMessage = new ChatMessage();
        $newMessage->user_id= Auth::id();
        $newMessage->chat_room_id = $roomId;
        $newMessage->message = $request->message;
        $newMessage->save();
        broadcast(new NewChatMessage($newMessage))->toOthers();
        return response()->json($newMessage);
    }
}
