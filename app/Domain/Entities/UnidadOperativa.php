<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnidadOperativa extends Model
{
    use HasFactory;

    /**
     * Tabla asociada al modelo.
     * @var string
     */
    protected $table = 'unidades_operativas';

    /**
     * Atributos asignables de forma masiva.
     * @var array<int, string>
     */
    protected $fillable = [
        'regional_id',
        'nombre',
    ];

    /**
     * Relación con la Regional (Pertenece a).
     * 
     * @return BelongsTo
     */
    public function regional(): BelongsTo
    {
        return $this->belongsTo(Regional::class, 'regional_id');
    }

    /**
     * Relación con los Almacenes (Tiene muchos).
     * 
     * @return HasMany
     */
    public function almacenes(): HasMany
    {
        return $this->hasMany(Almacen::class, 'unidad_operativa_id');
    }
}
