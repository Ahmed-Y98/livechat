<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class message extends Model
{
    protected $fillable = ['sender' , 'reciever' , 'body' , 'photo' , 'chat_token'];
}
