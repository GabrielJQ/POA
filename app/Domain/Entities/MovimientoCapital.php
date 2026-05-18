<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;

class MovimientoCapital extends Model
{
    protected $fillable = [
        'folio', 
        'tienda_id', 
        'tipo', 
        'fecha', 
        'costo', 
        'venta', 
        'metadata'
    ];
}
