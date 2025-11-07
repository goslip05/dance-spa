<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Servicio para manejar inscripciones a clases grupales
 */
class ClassEnrollmentService
{
    /**
     * Inscribir un estudiante a una clase
     */
    public function enroll(User $user, Schedule $schedule, ?string $expirationDate = null): Enrollment
    {
        // Validar que hay cupo disponible
        $activeEnrollments = $schedule->enrollments()
            ->where('status', 'active')
            ->count();

        if ($activeEnrollments >= $schedule->max_students) {
            throw new \Exception('La clase está llena');
        }

        // Verificar que el usuario no esté ya inscrito
        $existingEnrollment = Enrollment::where('user_id', $user->id)
            ->where('schedule_id', $schedule->id)
            ->where('status', 'active')
            ->first();

        if ($existingEnrollment) {
            throw new \Exception('Ya estás inscrito en esta clase');
        }

        // Crear la inscripción
        return Enrollment::create([
            'user_id' => $user->id,
            'schedule_id' => $schedule->id,
            'enrollment_date' => now(),
            'status' => 'active',
            'expiration_date' => $expirationDate,
        ]);
    }

    /**
     * Cancelar una inscripción
     */
    public function cancel(Enrollment $enrollment): bool
    {
        $enrollment->status = 'cancelled';
        return $enrollment->save();
    }

    /**
     * Pausar una inscripción
     */
    public function pause(Enrollment $enrollment): bool
    {
        $enrollment->status = 'paused';
        return $enrollment->save();
    }

    /**
     * Reactivar una inscripción pausada
     */
    public function reactivate(Enrollment $enrollment): bool
    {
        $enrollment->status = 'active';
        return $enrollment->save();
    }

    /**
     * Obtener inscripciones activas del usuario
     */
    public function getUserActiveEnrollments(User $user)
    {
        return $user->enrollments()
            ->where('status', 'active')
            ->with(['schedule.service', 'schedule.professional'])
            ->get();
    }
}
