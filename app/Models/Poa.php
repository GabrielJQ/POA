<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poa extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     * @var string
     */
    protected $table = 'poas';

    /**
     * Atributos asignables de forma masiva.
     * @var array<int, string>
     */
    protected $fillable = [
        'almacen_id',
        'anio',
        'tipo_registro',
        'presupuesto_venta_par',
        'presupuesto_venta_pe',
        'presupuesto_venta_total',
        'resultado_directo_operacion',
    ];

    /**
     * Conversión de tipos de datos.
     * @var array<string, string>
     */
    protected $casts = [
        'presupuesto_venta_par' => 'decimal:2',
        'presupuesto_venta_pe' => 'decimal:2',
        'presupuesto_venta_total' => 'decimal:2',
        'resultado_directo_operacion' => 'decimal:2',
    ];

    /**
     * Relación con el Almacén (Pertenece a).
     *
     * @return BelongsTo
     */
    public function almacen(): BelongsTo
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }
}
