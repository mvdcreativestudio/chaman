<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SumeriaSetting extends Model
{
    use HasFactory;

    protected $fillable = ['section_name', 'setting_name', 'setting_value', 'setting_type'];
}
