<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Professional;
use App\Models\Appointment;
use App\Services\AppointmentBookingService;
use App\Services\AvailabilityService;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct(
        private AppointmentBookingService $bookingService,
        private AvailabilityService $availabilityService
    ) {
    }

    public function index()
    {
        $services = Service::where('type', 'appointment')
            ->where('is_active', true)
            ->with('serviceCategory')
            ->get();

        return view('client.appointments.index', compact('services'));
    }

    public function create(Service $service)
    {
        $professionals = Professional::whereHas('serviceCategories', function ($q) use ($service) {
            $q->where('service_categories.id', $service->service_category_id);
        })->with('user')->where('is_available', true)->get();

        return view('client.appointments.create', compact('service', 'professionals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'professional_id' => 'required|exists:professionals,id',
            'appointment_date' => 'required|date|after:today',
            'start_time' => 'required',
            'notes' => 'nullable|string',
        ]);

        try {
            $service = Service::findOrFail($request->service_id);
            $professional = Professional::findOrFail($request->professional_id);

            $this->bookingService->book(
                $service,
                $professional,
                auth()->user(),
                $request->appointment_date,
                $request->start_time,
                $request->notes
            );

            return redirect()->route('client.appointments.my-appointments')
                ->with('success', '¡Cita agendada exitosamente!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function myAppointments()
    {
        $appointments = Appointment::where('client_id', auth()->id())
            ->with(['service', 'professional.user'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('client.appointments.my-appointments', compact('appointments'));
    }
}
