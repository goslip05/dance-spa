<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\Professional;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;

/**
 * Servicio para agendar citas de spa
 */
class AppointmentBookingService
{
    protected $availabilityService;

    public function __construct(AvailabilityService $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    /**
     * Crear una nueva cita
     */
    public function book(
        Service $service,
        Professional $professional,
        User $client,
        string $date,
        string $startTime,
        ?string $notes = null
    ): Appointment {
        $startTime = Carbon::parse("$date $startTime");
        $endTime = $startTime->copy()->addMinutes($service->duration);

        // Validar disponibilidad
        if (!$this->availabilityService->isProfessionalAvailable($professional, $startTime, $endTime)) {
            throw new \Exception('El profesional no está disponible en este horario');
        }

        // Crear la cita
        return Appointment::create([
            'service_id' => $service->id,
            'professional_id' => $professional->id,
            'client_id' => $client->id,
            'appointment_date' => $date,
            'start_time' => $startTime->format('H:i'),
            'end_time' => $endTime->format('H:i'),
            'status' => 'pending',
            'notes' => $notes,
        ]);
    }

    /**
     * Confirmar una cita
     */
    public function confirm(Appointment $appointment): bool
    {
        $appointment->status = 'confirmed';
        return $appointment->save();
    }

    /**
     * Cancelar una cita
     */
    public function cancel(Appointment $appointment): bool
    {
        $appointment->status = 'cancelled';
        return $appointment->save();
    }

    /**
     * Marcar cita como completada
     */
    public function complete(Appointment $appointment, ?string $internalNotes = null): bool
    {
        $appointment->status = 'completed';
        if ($internalNotes) {
            $appointment->internal_notes = $internalNotes;
        }
        return $appointment->save();
    }

    /**
     * Obtener citas próximas del cliente
     */
    public function getUpcomingAppointments(User $client)
    {
        return Appointment::where('client_id', $client->id)
            ->upcoming()
            ->with(['service', 'professional.user'])
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->get();
    }
}
