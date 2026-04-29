<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConceptoMaestro extends Model
{
    protected $table = 'conceptos_maestros';

    protected $fillable = [
        'nombre',
        'categoria',
        'unidad_medida',
        'orden',
        'label_fila_1',
        'label_fila_2',
        'numero',
        'descripcion',
    ];

    public function registros(): HasMany
    {
        return $this->hasMany(RegistroFinanciero::class, 'concepto_id');
    }
}
