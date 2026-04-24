<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Regional extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     * @var string
     */
    protected $table = 'regionales';

    /**
     * Atributos asignables de forma masiva.
     * @var array<int, string>
     */
    protected $fillable = [
        'clave_region',
        'nombre',
    ];

    /**
     * Obtiene las unidades operativas asociadas a la regional.
     * 
     * @return HasMany
     */
    public function unidadesOperativas(): HasMany
    {
        return $this->hasMany(UnidadOperativa::class, 'regional_id');
    }
}
