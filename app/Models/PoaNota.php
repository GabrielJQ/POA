<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PoaNota extends Model
{
    protected $table = 'poa_notas';

    protected $fillable = [
        'concepto_id',
        'almacen_id',
        'label',
        'anio',
        'mes',
        'nota_aclaratoria',
    ];

    protected $casts = [
        'mes' => 'integer',
        'anio' => 'integer',
    ];

    public function concepto()
    {
        return $this->belongsTo(ConceptoMaestro::class, 'concepto_id');
    }
}
