<?php

namespace App\Http\Controllers;
use App\Room;
use App\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\NewChatMessage;
use App\Events\NewChatRoom;
use App\Role;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class ChatController extends Controller
{
    public function signIn(Request $data)
    {
        try {
            $user = User::where('email',$data->email)->first();
            if(!$user){
                $user = new User();
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->password = Hash::make('12345678');
                $user->save();
                $role = Role::where('name', $data['role'])->first();
                $user->roles()->attach($role);
                
                return $this->newRoom($data);
            }
            return $this->newRoom($data);
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function newRoom($data){
        //$token = $request->bearerToken();
        //return JWTAuth::toUser($token);
        return Auth::login($data);
        $user = Auth::user();
        $room = Room::where('creator',$user->id)
        ->where('user_id', $data->listener )//user_id is the listener
        ->orWhere('user_id', $user->id )
        ->first();
        if(!$room){
            $newRoom = new Room();
            $newRoom->name = $data['name'];
            $newRoom->creator = $user->id;
            $newRoom->user_id = $data->listener;
            $newRoom->save();
            broadcast(new NewChatRoom($newRoom))->toOthers();
            return response()->json($newRoom);
        }
        return response()->json($room);
    }
    
    public function rooms($id){
        $user = Auth::user();
        $rooms= Room::with('user')
        ->where('creator',$user->id)
        ->orWhere('user_id',$user->id)
        ->get();
        return response()->json($rooms);
    }
    public function messages(Request $request, $roomId){
        $messages= Message::where('room_id', $roomId)
        ->with('user')
        ->orderBy('created_at', 'DESC')
        ->get();
        return response()->json($messages);
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
