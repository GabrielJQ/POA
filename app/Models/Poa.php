<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poa extends Model
{
    use HasFactory;

    protected $table = 'poas';

    protected $fillable = [
        'almacen_id',
        'anio',
        'tipo_registro',
        'presupuesto_venta_par',
        'presupuesto_venta_pe',
        'presupuesto_venta_total',
        'resultado_directo_operacion',
    ];

    protected $casts = [
        'presupuesto_venta_par' => 'decimal:2',
        'presupuesto_venta_pe' => 'decimal:2',
        'presupuesto_venta_total' => 'decimal:2',
        'resultado_directo_operacion' => 'decimal:2',
    ];

    public function almacen(): BelongsTo
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function getPresupuestoVentaParAttribute(): float
    {
        if (!$this->almacen_id || !$this->anio) {
            return $this->attributes['presupuesto_venta_par'] ?? 0;
        }
        return RegistroFinanciero::where('almacen_id', $this->almacen_id)
            ->where('programa', 'PAR')
            ->where('anio', $this->anio)
            ->where('tipo_dato', 'REAL')
            ->get()
            ->sum('monto');
    }

    public function getPresupuestoVentaPeAttribute(): float
    {
        if (!$this->almacen_id || !$this->anio) {
            return $this->attributes['presupuesto_venta_pe'] ?? 0;
        }
        return RegistroFinanciero::where('almacen_id', $this->almacen_id)
            ->where('programa', 'PE')
            ->where('anio', $this->anio)
            ->where('tipo_dato', 'REAL')
            ->get()
            ->sum('monto');
    }

    public function getPresupuestoVentaTotalAttribute(): float
    {
        return $this->presupuesto_venta_par + $this->presupuesto_venta_pe;
    }
}
