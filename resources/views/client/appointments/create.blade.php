<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📅 Agendar Cita: {{ $service->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('client.appointments.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    ← Volver
                </a>
            </div>

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6 pb-6 border-b">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $service->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ $service->description }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">
                                <span class="font-semibold">Duración:</span> {{ $service->duration }} min
                            </span>
                            <span class="text-2xl font-bold text-teal-600">${{ number_format($service->price, 0) }}</span>
                        </div>
                    </div>

                    <form action="{{ route('client.appointments.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">

                        <div>
                            <label for="professional_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Seleccionar Profesional *
                            </label>
                            <select name="professional_id" id="professional_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <option value="">Seleccione un profesional...</option>
                                @foreach($professionals as $professional)
                                    <option value="{{ $professional->id }}" {{ old('professional_id') == $professional->id ? 'selected' : '' }}>
                                        {{ $professional->user->name }}
                                        @if($professional->specialties)
                                            - ({{ implode(', ', $professional->specialties) }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('professional_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="appointment_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Fecha de la Cita *
                            </label>
                            <input type="date" name="appointment_date" id="appointment_date" value="{{ old('appointment_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                            @error('appointment_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                                Hora de Inicio *
                            </label>
                            <select name="start_time" id="start_time" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500">
                                <option value="">Seleccione una hora...</option>
                                @for($hour = 8; $hour < 20; $hour++)
                                    <option value="{{ sprintf('%02d:00', $hour) }}">{{ sprintf('%02d:00', $hour) }}</option>
                                    <option value="{{ sprintf('%02d:30', $hour) }}">{{ sprintf('%02d:30', $hour) }}</option>
                                @endfor
                            </select>
                            @error('start_time')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Notas (opcional)
                            </label>
                            <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500" placeholder="Alguna indicación especial...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('client.appointments.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition">
                                Cancelar
                            </a>
                            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-teal-500 to-cyan-600 text-white font-bold rounded-lg hover:from-teal-600 hover:to-cyan-700 transition">
                                Confirmar Cita
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
