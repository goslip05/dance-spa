<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use App\Models\Appointment;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        $professional = Professional::where('user_id', auth()->id())->first();

        if (!$professional) {
            abort(403, 'No tienes un perfil de profesional');
        }

        $appointments = Appointment::where('professional_id', $professional->id)
            ->whereIn('status', ['pending', 'confirmed', 'in_progress'])
            ->with(['service', 'client'])
            ->orderBy('appointment_date')
            ->orderBy('start_time')
            ->get();

        $schedules = Schedule::where('professional_id', $professional->id)
            ->with('service')
            ->get();

        return view('professional.agenda.index', compact('appointments', 'schedules'));
    }

    public function complete(Appointment $appointment, Request $request)
    {
        $professional = Professional::where('user_id', auth()->id())->first();

        if ($appointment->professional_id !== $professional->id) {
            abort(403);
        }

        $appointment->update([
            'status' => 'completed',
            'internal_notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Cita marcada como completada');
    }
}
