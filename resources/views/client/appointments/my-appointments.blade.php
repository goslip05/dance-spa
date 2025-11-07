<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📋 Mis Citas
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('client.appointments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    ← Ver Servicios
                </a>
            </div>

            @if($appointments->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-6xl mb-4">📅</div>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">No tienes citas agendadas</h3>
                        <p class="text-gray-500 mb-4">¡Agenda tu primera cita de spa y relájate!</p>
                        <a href="{{ route('client.appointments.index') }}" class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700">
                            Ver Servicios Disponibles
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($appointments as $appointment)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-xl font-bold text-gray-900">{{ $appointment->service->name }}</h3>
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full
                                        {{ $appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $appointment->status === 'confirmed' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $appointment->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $appointment->status === 'completed' ? 'bg-gray-100 text-gray-700' : '' }}
                                        {{ $appointment->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                        {{ $appointment->status === 'no_show' ? 'bg-gray-100 text-gray-700' : '' }}">
                                        @switch($appointment->status)
                                            @case('pending') Pendiente @break
                                            @case('confirmed') Confirmada @break
                                            @case('in_progress') En Progreso @break
                                            @case('completed') Completada @break
                                            @case('cancelled') Cancelada @break
                                            @case('no_show') No Asistió @break
                                        @endswitch
                                    </span>
                                </div>

                                <div class="space-y-2 mb-4">
                                    <p class="text-gray-600">
                                        <span class="font-semibold">📅 Fecha:</span>
                                        {{ $appointment->appointment_date->format('d/m/Y') }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-semibold">⏰ Hora:</span>
                                        {{ date('g:i A', strtotime($appointment->start_time)) }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-semibold">👤 Profesional:</span>
                                        {{ $appointment->professional->user->name }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-semibold">⏱️ Duración:</span>
                                        {{ $appointment->service->duration }} minutos
                                    </p>
                                    @if($appointment->notes)
                                        <p class="text-gray-600">
                                            <span class="font-semibold">📝 Notas:</span>
                                            {{ $appointment->notes }}
                                        </p>
                                    @endif
                                </div>

                                <div class="text-sm text-gray-500">
                                    Agendada el {{ $appointment->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
