<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;
    protected $fillable =[
        'message', 
        'user_id'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}

