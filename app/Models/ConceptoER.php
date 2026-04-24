<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConceptoER extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     * @var string
     */
    protected $table = 'conceptos_er';

    /**
     * Atributos asignables de forma masiva.
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'categoria',
        'tipo',
        'orden_visual',
        'es_calculado',
    ];

    /**
     * Conversión de tipos de datos.
     * @var array<string, string>
     */
    protected $casts = [
        'es_calculado' => 'boolean',
        'tipo' => 'integer',
    ];

    /**
     * Relación con los Resultados Mensuales (Tiene muchos).
     * 
     * @return HasMany
     */
    public function resultadosMensuales(): HasMany
    {
        return $this->hasMany(ResultadoMensual::class, 'concepto_er_id');
    }
}
