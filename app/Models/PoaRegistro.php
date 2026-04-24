<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PoaRegistro extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     * @var string
     */
    protected $table = 'poa_registros';

    /**
     * Atributos asignables de forma masiva.
     * @var array<int, string>
     */
    protected $fillable = [
        'compromiso_poa_id',
        'almacen_id',
        'anio',
        'tipo_registro',
        'meta_anual',
        'mes_01', 'mes_02', 'mes_03', 'mes_04',
        'mes_05', 'mes_06', 'mes_07', 'mes_08',
        'mes_09', 'mes_10', 'mes_11', 'mes_12',
        'nota_aclaratoria',
    ];

    /**
     * Conversión de tipos de datos.
     * @var array<string, string>
     */
    protected $casts = [
        'meta_anual' => 'decimal:2',
    ];

    /**
     * Relación con el Compromiso POA (Pertenece a).
     */
    public function compromiso(): BelongsTo
    {
        return $this->belongsTo(CompromisoPoa::class, 'compromiso_poa_id');
    }

    /**
     * Relación con el Almacén (Pertenece a).
     */
    public function almacen(): BelongsTo
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    /**
     * Obtiene el valor de un mes específico (1-12).
     */
    public function getMes(int $mes): float
    {
        $col = 'mes_' . str_pad($mes, 2, '0', STR_PAD_LEFT);
        return (float) ($this->$col ?? 0);
    }
}
