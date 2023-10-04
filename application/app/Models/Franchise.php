<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Franchise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'is_disabled'
    ];

    public function users() {
        return $this->hasMany('App\Models\User', 'franchise_id', 'id');
    }
}

