<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'lineas',
        'impuestos',
        'subtotal',
        'total',
        'moneda',
        'moneda_id',
        'estado',
        'fecha_creacion',
        'fecha_emision',
        'pagos',
        'ruc_franquicia',
        'accion',
    ];

    protected $casts = [
        'lineas' => 'json',
        'impuestos' => 'json',
        'pagos' => 'json',
    ];

    // Otras propiedades y métodos del modelo...
}
