<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📚 Mis Clases
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('client.classes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    ← Volver al Catálogo
                </a>
            </div>

            @if($enrollments->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-6xl mb-4">😔</div>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">No tienes clases inscritas</h3>
                        <p class="text-gray-500 mb-4">¡Inscríbete a una clase y comienza a bailar!</p>
                        <a href="{{ route('client.classes.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Ver Clases Disponibles
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($enrollments as $enrollment)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <h3 class="text-xl font-bold text-gray-900">{{ $enrollment->schedule->service->name }}</h3>
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full
                                        {{ $enrollment->status === 'active' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $enrollment->status === 'paused' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $enrollment->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                        {{ $enrollment->status === 'completed' ? 'bg-blue-100 text-blue-700' : '' }}">
                                        {{ ucfirst($enrollment->status) }}
                                    </span>
                                </div>

                                <div class="space-y-2 mb-4">
                                    <p class="text-gray-600">
                                        <span class="font-semibold">📅 Día:</span>
                                        {{ ['','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'][$enrollment->schedule->day_of_week] }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-semibold">⏰ Horario:</span>
                                        {{ date('g:i A', strtotime($enrollment->schedule->start_time)) }} - {{ date('g:i A', strtotime($enrollment->schedule->end_time)) }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-semibold">👤 Profesor:</span>
                                        {{ $enrollment->schedule->professional->user->name }}
                                    </p>
                                    <p class="text-gray-600">
                                        <span class="font-semibold">📍 Sala:</span>
                                        {{ $enrollment->schedule->room }}
                                    </p>
                                    @if($enrollment->expiration_date)
                                        <p class="text-gray-600">
                                            <span class="font-semibold">📆 Vence:</span>
                                            {{ $enrollment->expiration_date->format('d/m/Y') }}
                                        </p>
                                    @endif
                                </div>

                                <div class="text-sm text-gray-500">
                                    Inscrito el {{ $enrollment->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
