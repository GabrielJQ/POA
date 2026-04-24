<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Almacen extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     * @var string
     */
    protected $table = 'almacenes';

    /**
     * Atributos asignables de forma masiva.
     * @var array<int, string>
     */
    protected $fillable = [
        'unidad_operativa_id',
        'clave_almacen',
        'nombre',
        'direccion',
    ];

    /**
     * Relación con la Unidad Operativa (Pertenece a).
     * 
     * @return BelongsTo
     */
    public function unidadOperativa(): BelongsTo
    {
        return $this->belongsTo(UnidadOperativa::class, 'unidad_operativa_id');
    }

    /**
     * Relación con los Resultados Mensuales (Tiene muchos).
     * 
     * @return HasMany
     */
    public function resultadosMensuales(): HasMany
    {
        return $this->hasMany(ResultadoMensual::class, 'almacen_id');
    }
}
