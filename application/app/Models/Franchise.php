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

    public function objectives()
    {
        return $this->hasMany(Objective::class, 'user_id');
    }

    public function invoices() {
        return $this->hasMany('App\Models\Invoice');
    }
    
    public function payments()
    {
        return $this->hasMany(\App\Models\Payment::class, 'franchise_id');
    }

    public function leads()
    {
        return $this->hasMany('App\Models\Lead', 'franchise_id', 'id');
    }
    
    public function projects()
    {
        return $this->hasMany('App\Models\Project', 'franchise_id');
    }

    public function clients()
    {
        return $this->hasMany('App\Models\Client', 'franchise_id', 'client_id');
    }

}

