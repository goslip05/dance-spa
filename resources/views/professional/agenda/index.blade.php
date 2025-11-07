<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📅 Mi Agenda Profesional
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Citas Próximas -->
            <div class="mb-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-4">📋 Citas Próximas</h3>

                @if($appointments->isEmpty())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center">
                            <div class="text-4xl mb-2">✨</div>
                            <p class="text-gray-600">No tienes citas programadas</p>
                        </div>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($appointments as $appointment)
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4
                                {{ $appointment->status === 'confirmed' ? 'border-green-500' : '' }}
                                {{ $appointment->status === 'pending' ? 'border-yellow-500' : '' }}
                                {{ $appointment->status === 'in_progress' ? 'border-blue-500' : '' }}">
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-3">
                                        <h4 class="text-lg font-bold text-gray-900">{{ $appointment->service->name }}</h4>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                            {{ $appointment->status === 'confirmed' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $appointment->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : '' }}">
                                            @switch($appointment->status)
                                                @case('pending') Pendiente @break
                                                @case('confirmed') Confirmada @break
                                                @case('in_progress') En Progreso @break
                                            @endswitch
                                        </span>
                                    </div>

                                    <div class="space-y-2 mb-4">
                                        <p class="text-sm text-gray-600">
                                            <span class="font-semibold">👤 Cliente:</span>
                                            {{ $appointment->client->name }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-semibold">📅 Fecha:</span>
                                            {{ $appointment->appointment_date->format('d/m/Y') }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-semibold">⏰ Hora:</span>
                                            {{ date('g:i A', strtotime($appointment->start_time)) }}
                                        </p>
                                        @if($appointment->notes)
                                            <p class="text-sm text-gray-600">
                                                <span class="font-semibold">📝 Notas:</span>
                                                {{ $appointment->notes }}
                                            </p>
                                        @endif
                                    </div>

                                    @if($appointment->status !== 'completed')
                                        <form action="{{ route('professional.agenda.complete', $appointment) }}" method="POST" class="mt-4">
                                            @csrf
                                            <button type="submit" class="w-full bg-green-600 text-white font-bold py-2 px-4 rounded hover:bg-green-700 transition">
                                                ✓ Marcar como Completada
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Horarios de Clases -->
            <div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">🗓️ Mis Clases Programadas</h3>

                @if($schedules->isEmpty())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-center">
                            <div class="text-4xl mb-2">📚</div>
                            <p class="text-gray-600">No tienes clases programadas</p>
                        </div>
                    </div>
                @else
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($schedules as $schedule)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <h4 class="text-lg font-bold text-gray-900 mb-3">{{ $schedule->service->name }}</h4>

                                        <div class="space-y-2">
                                            <p class="text-sm text-gray-600">
                                                <span class="font-semibold">📅 Día:</span>
                                                {{ ['','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'][$schedule->day_of_week] }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                <span class="font-semibold">⏰ Horario:</span>
                                                {{ date('g:i A', strtotime($schedule->start_time)) }} - {{ date('g:i A', strtotime($schedule->end_time)) }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                <span class="font-semibold">📍 Sala:</span>
                                                {{ $schedule->room }}
                                            </p>
                                            @php
                                                $enrolled = $schedule->enrollments->where('status', 'active')->count();
                                            @endphp
                                            <p class="text-sm text-gray-600">
                                                <span class="font-semibold">👥 Inscritos:</span>
                                                {{ $enrolled }}/{{ $schedule->max_students }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
