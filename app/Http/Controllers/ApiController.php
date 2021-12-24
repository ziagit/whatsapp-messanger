<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Exception;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Room;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function signIn(Request $data)
    {
        try {
            $user = User::where('email',$data->email)->first();
            if($user){
                if ($token = jWTAuth::attempt(['email' => $data->email, 'password' => '12345678'])) {
                    return response()->json($token);
                }
            }
            $this->signUp($data);
            if ($token = jWTAuth::attempt(['email' => $data->email, 'password' => '12345678'])) {
                return response()->json($token);
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function signUp($data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make('12345678');
        $user->save();
        $role = Role::where('name', 'User')->first();
        $user->roles()->attach($role);
        return $user;
    }
    public function me(){
        
    }
    public function signout(){

        $user = Auth::user();
        if($user){
            $rooms = Room::where('creator',$user->id)->where('status','Active')->orWhere('listener',$user->id)->get();
            foreach($rooms as $room){
                $room->status = 'Inactive';
                $room->update();
            }
            Auth::logout();
            return response()->json("Loged out.",200);
        }
    }
}
