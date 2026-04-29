<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistroFinanciero extends Model
{
    protected $table = 'registros_financieros';

    protected $fillable = [
        'almacen_id',
        'concepto_id',
        'mes',
        'anio',
        'monto',
        'tipo_dato',
        'programa',
    ];

    protected $casts = [
        'monto' => 'encrypted',
        'mes' => 'integer',
        'anio' => 'integer',
    ];

    public function almacen(): BelongsTo
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function concepto(): BelongsTo
    {
        return $this->belongsTo(ConceptoMaestro::class, 'concepto_id');
    }
}
