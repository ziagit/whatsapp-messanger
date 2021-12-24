<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function room(){
        return $this->hasOne(Room::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
