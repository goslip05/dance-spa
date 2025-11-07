<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Categoría de servicio
 *
 * Representa las tres categorías principales del sistema:
 * - DANCE_CLASSES: Clases grupales de baile
 * - SPA_SERVICES: Servicios de spa y belleza
 * - PRODUCTS: Productos físicos y paquetes
 */
class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'slug',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Obtener los servicios de esta categoría
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Obtener los profesionales que trabajan en esta categoría
     */
    public function professionals(): BelongsToMany
    {
        return $this->belongsToMany(Professional::class, 'professional_service_category');
    }

    /**
     * Scope para categorías activas
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope por tipo de categoría
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }
}
