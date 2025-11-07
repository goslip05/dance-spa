<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Servicio genérico
 *
 * Puede ser una clase de baile, servicio de spa, o producto
 */
class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_category_id',
        'name',
        'description',
        'price',
        'duration',
        'type',
        'max_capacity',
        'requires_professional',
        'image',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'duration' => 'integer',
        'max_capacity' => 'integer',
        'requires_professional' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Obtener la categoría del servicio
     */
    public function serviceCategory(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    /**
     * Obtener los horarios de este servicio (para clases)
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Obtener las citas de este servicio (para spa)
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Obtener los items de órdenes relacionados
     */
    public function orderItems(): MorphMany
    {
        return $this->morphMany(OrderItem::class, 'orderable');
    }

    /**
     * Scope para servicios activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope por tipo de servicio
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope para servicios que requieren profesional
     */
    public function scopeRequiresProfessional($query)
    {
        return $query->where('requires_professional', true);
    }
}
