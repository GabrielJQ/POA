<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacenes';

    protected $fillable = [
        'unidad_operativa_id',
        'clave_almacen',
        'nombre',
        'direccion',
    ];

    public function unidadOperativa(): BelongsTo
    {
        return $this->belongsTo(UnidadOperativa::class, 'unidad_operativa_id');
    }

    public function registrosFinancieros(): HasMany
    {
        return $this->hasMany(RegistroFinanciero::class, 'almacen_id');
    }
}
