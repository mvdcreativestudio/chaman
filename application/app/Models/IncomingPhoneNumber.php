<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingPhoneNumber extends Model
{
    use HasFactory;

    protected $fillable = ['phone_number', 'phone_id', 'phone_number_owner'];

    public function sentMessages()
    {
        return $this->morphMany(Message::class, 'from_phone');
    }

    public function receivedMessages()
    {
        return $this->morphMany(Message::class, 'to_phone');
    }
}
