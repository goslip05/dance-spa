<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            💃 Clases de Baile
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="mb-8">
                <a href="{{ route('client.classes.my-classes') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Ver Mis Clases
                </a>
            </div>

            @foreach($schedules as $className => $classSchedules)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $className }}</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($classSchedules as $schedule)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <span class="inline-block px-3 py-1 text-sm font-semibold text-indigo-700 bg-indigo-100 rounded-full">
                                                {{ ['','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'][$schedule->day_of_week] }}
                                            </span>
                                        </div>
                                        <span class="text-lg font-bold text-gray-900">${{ number_format($schedule->service->price, 0) }}</span>
                                    </div>

                                    <div class="space-y-2 mb-4">
                                        <p class="text-gray-600">
                                            <span class="font-semibold">⏰ Horario:</span>
                                            {{ date('g:i A', strtotime($schedule->start_time)) }} - {{ date('g:i A', strtotime($schedule->end_time)) }}
                                        </p>
                                        <p class="text-gray-600">
                                            <span class="font-semibold">👤 Profesor:</span>
                                            {{ $schedule->professional->user->name }}
                                        </p>
                                        <p class="text-gray-600">
                                            <span class="font-semibold">📍 Sala:</span>
                                            {{ $schedule->room }}
                                        </p>
                                        @php
                                            $enrolled = $schedule->enrollments->where('status', 'active')->count();
                                            $available = $schedule->max_students - $enrolled;
                                        @endphp
                                        <p class="text-gray-600">
                                            <span class="font-semibold">👥 Cupos:</span>
                                            <span class="{{ $available > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $available }} disponibles
                                            </span>
                                        </p>
                                    </div>

                                    @if($available > 0)
                                        <form action="{{ route('client.classes.enroll', $schedule) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-2 px-4 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition">
                                                Inscribirse Ahora
                                            </button>
                                        </form>
                                    @else
                                        <button disabled class="w-full bg-gray-300 text-gray-500 font-bold py-2 px-4 rounded-lg cursor-not-allowed">
                                            Clase Llena
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
