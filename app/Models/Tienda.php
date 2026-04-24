<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    protected $fillable = ['numero_tienda', 'comunidad', 'unidad_operativa_id'];
}
