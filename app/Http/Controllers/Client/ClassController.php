<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\Enrollment;
use App\Services\ClassEnrollmentService;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function __construct(private ClassEnrollmentService $enrollmentService)
    {
    }

    public function index()
    {
        $schedules = Schedule::with(['service', 'professional.user'])
            ->whereHas('service', fn($q) => $q->where('type', 'class')->where('is_active', true))
            ->get()
            ->groupBy('service.name');

        return view('client.classes.index', compact('schedules'));
    }

    public function enroll(Schedule $schedule)
    {
        try {
            $this->enrollmentService->enroll(auth()->user(), $schedule);
            return redirect()->back()->with('success', '¡Te has inscrito exitosamente a la clase!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function myClasses()
    {
        $enrollments = Enrollment::where('user_id', auth()->id())
            ->with(['schedule.service', 'schedule.professional.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.classes.my-classes', compact('enrollments'));
    }
}
