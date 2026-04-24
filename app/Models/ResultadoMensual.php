<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResultadoMensual extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     * @var string
     */
    protected $table = 'resultados_mensuales';

    /**
     * Atributos asignables de forma masiva.
     * @var array<int, string>
     */
    protected $fillable = [
        'almacen_id',
        'concepto_er_id',
        'anio',
        'mes',
        'monto',
    ];

    /**
     * Accesor Moderno para el Monto Real.
     * Multiplica el monto por el tipo de concepto (1 o -1) para reflejar impacto contable.
     * 
     * @return Attribute
     */
    protected function montoReal(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->monto * ($this->concepto->tipo ?? 1),
        );
    }

    /**
     * Relación con el Almacén (Pertenece a).
     * 
     * @return BelongsTo
     */
    public function almacen(): BelongsTo
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    /**
     * Relación con el Concepto del Estado de Resultados (Pertenece a).
     * 
     * @return BelongsTo
     */
    public function concepto(): BelongsTo
    {
        return $this->belongsTo(ConceptoER::class, 'concepto_er_id');
    }
}
