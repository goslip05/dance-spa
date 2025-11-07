<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Professional;
use App\Models\Schedule;
use Carbon\Carbon;

/**
 * Servicio para verificar disponibilidad de profesionales
 */
class AvailabilityService
{
    /**
     * Verificar si un profesional está disponible en un horario específico
     */
    public function isProfessionalAvailable(
        Professional $professional,
        Carbon $startTime,
        Carbon $endTime
    ): bool {
        if (!$professional->is_available) {
            return false;
        }

        // Verificar citas superpuestas
        $overlappingAppointments = Appointment::where('professional_id', $professional->id)
            ->where('appointment_date', $startTime->toDateString())
            ->whereIn('status', ['pending', 'confirmed', 'in_progress'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime->format('H:i'), $endTime->format('H:i')])
                    ->orWhereBetween('end_time', [$startTime->format('H:i'), $endTime->format('H:i')])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime->format('H:i'))
                          ->where('end_time', '>=', $endTime->format('H:i'));
                    });
            })
            ->exists();

        return !$overlappingAppointments;
    }

    /**
     * Obtener slots disponibles para un profesional en una fecha
     */
    public function getAvailableSlots(
        Professional $professional,
        string $date,
        int $duration = 60
    ): array {
        $slots = [];
        $startHour = 8; // 8 AM
        $endHour = 20; // 8 PM

        for ($hour = $startHour; $hour < $endHour; $hour++) {
            $slotStart = Carbon::parse("$date $hour:00");
            $slotEnd = $slotStart->copy()->addMinutes($duration);

            if ($this->isProfessionalAvailable($professional, $slotStart, $slotEnd)) {
                $slots[] = [
                    'start' => $slotStart->format('H:i'),
                    'end' => $slotEnd->format('H:i'),
                ];
            }
        }

        return $slots;
    }

    /**
     * Verificar si una clase tiene cupo disponible
     */
    public function hasAvailableSpots(Schedule $schedule): bool
    {
        $activeEnrollments = $schedule->enrollments()
            ->where('status', 'active')
            ->count();

        return $activeEnrollments < $schedule->max_students;
    }
}
