<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FranchisePhone extends Model
{
    use HasFactory;

    protected $table = 'franchise_phone';

    protected $fillable = ['franchise_id', 'phone_id', 'phone_number'];

    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }

    public function sentMessages()
    {
        return $this->morphMany(Message::class, 'from_phone');
    }

    public function receivedMessages()
    {
        return $this->morphMany(Message::class, 'to_phone');
    }
}
