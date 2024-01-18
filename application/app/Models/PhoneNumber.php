<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    protected $fillable = ['phone_id', 'phone_number', 'is_franchise', 'phone_number_owner', 'franchise_id'];

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'from_phone_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'to_phone_id');
    }

    public function franchise()
    {
        return $this->belongsTo(Franchise::class, 'franchise_id');
    }

    public function getLastMessagesForChats()
    {
        $phoneNumbers = Message::where('from_phone_id', $this->id)
                               ->orWhere('to_phone_id', $this->id)
                               ->get()
                               ->pluck('to_phone_id', 'from_phone_id')
                               ->keys()
                               ->merge(
                                   Message::where('from_phone_id', $this->id)
                                          ->orWhere('to_phone_id', $this->id)
                                          ->get()
                                          ->pluck('from_phone_id', 'to_phone_id')
                                          ->keys()
                               )
                               ->unique();
    
        $lastMessages = collect();
    
        foreach ($phoneNumbers as $otherPhoneId) {
            if ($otherPhoneId == $this->id) {
                continue;
            }
    
            $lastMessage = Message::where(function ($query) use ($otherPhoneId) {
                                    $query->where('from_phone_id', $this->id)
                                          ->where('to_phone_id', $otherPhoneId);
                                })
                                ->orWhere(function ($query) use ($otherPhoneId) {
                                    $query->where('from_phone_id', $otherPhoneId)
                                          ->where('to_phone_id', $this->id);
                                })
                                ->latest('message_created')
                                ->first();
    
            if ($lastMessage) {
                $lastMessages->push($lastMessage);
            }
        }
    
        return $lastMessages;
    }
    
}
