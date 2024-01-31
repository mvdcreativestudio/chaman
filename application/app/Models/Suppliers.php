<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'razon_social', 'direccion', 'telefono', 'celular', 'email', 'ciudad', 'departamento', 'pais', 'rucFranquicia', 'accion'];
}
