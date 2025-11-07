<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Horario fijo para clases grupales recurrentes
 */
class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'professional_id',
        'day_of_week',
        'start_time',
        'end_time',
        'room',
        'max_students',
        'recurrence_type',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'max_students' => 'integer',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function professional(): BelongsTo
    {
        return $this->belongsTo(Professional::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function scopeByDay($query, int $day)
    {
        return $query->where('day_of_week', $day);
    }

    public function scopeWithAvailableSpots($query)
    {
        return $query->whereHas('enrollments', function ($q) {
            $q->where('status', 'active');
        }, '<', $query->getModel()->max_students);
    }
}
