<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompromisoPoa extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     * @var string
     */
    protected $table = 'compromisos_poa';

    /**
     * Atributos asignables de forma masiva.
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'unidad_medida',
        'orden',
        'concepto_er_nombre',
        'label_fila_1',
        'label_fila_2',
    ];

    /**
     * Relación con los registros POA (Tiene muchos).
     *
     * @return HasMany
     */
    public function registros(): HasMany
    {
        return $this->hasMany(PoaRegistro::class, 'compromiso_poa_id');
    }

    /**
     * Verifica si este compromiso se mapea automáticamente desde el ER.
     */
    public function tieneMappingER(): bool
    {
        return !empty($this->concepto_er_nombre);
    }
}
