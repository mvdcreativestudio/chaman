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
}
