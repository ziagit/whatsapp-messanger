<?php

namespace App\Http\Controllers;
use App\Room;
use App\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\NewChatMessage;
use App\Events\NewChatRoom;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function newRoom(Request $request){
        $user = Auth::user();
        if($request->listener == 0){
            $room = Room::where('creator', $user->id )->first();
            if(!$room){
                $newRoom = new Room();
                $newRoom->name = $user->name;
                $newRoom->creator = $user->id;
                $newRoom->user_id = $request->listener;
                $newRoom->save();
                return [ 
                    'id'=>$user->id,
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'role'=>$user->roles[0]->name,
                    'listener'=>$newRoom->user_id];
            }
            return [
                'id'=>$user->id,
                'name'=>$user->name,
                'email'=>$user->email,
                'role'=>$user->roles[0]->name,
                'listener'=>$room->user_id];
        }
        $room = Room::where('creator',$user->id)
        ->where('user_id', $request->listener )
        ->orWhere('user_id', $user->id )
        ->first();
        if(!$room){
            $newRoom = new Room();
            $newRoom->name = $user->name;
            $newRoom->creator = $user->id;
            $newRoom->user_id = $request->listener;
            $newRoom->save();
            broadcast(new NewChatRoom($newRoom))->toOthers();
            return [
                'id'=>$user->id,
                'name'=>$user->name,
                'email'=>$user->email,
                'role'=>$user->roles[0]->name,
                'listener'=>$newRoom->listener];
        }
        return [
            'id'=>$user->id,
            'name'=>$user->name,
            'email'=>$user->email,
            'role'=>$user->roles[0]->name,
            'listener'=>$room->user_id];
    }
    
    public function rooms($id){
        $user = Auth::user();
        return Room::with('user')
        ->where('creator',$user->id)
        ->orWhere('user_id',$user->id)
        ->get();
    }
    public function messages(Request $request, $roomId){
        return Message::where('room_id', $roomId)
        ->with('user')
        ->orderBy('created_at', 'DESC')
        ->get();
    }

    public function newMessage(Request $request, $roomId){
        $newMessage = new Message();
        $newMessage->user_id= Auth::id();
        $newMessage->room_id = $roomId;
        $newMessage->message = $request->message;
        $newMessage->save();
        broadcast(new NewChatMessage($newMessage))->toOthers();
        return response()->json($newMessage);
    }
}
