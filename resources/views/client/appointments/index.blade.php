<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            💆 Servicios de Spa
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('client.appointments.my-appointments') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Ver Mis Citas
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($services as $service)
                    <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg hover:shadow-xl transition transform hover:-translate-y-1">
                        <div class="h-48 bg-gradient-to-br from-teal-400 to-cyan-600 flex items-center justify-center">
                            <span class="text-6xl">💆‍♀️</span>
                        </div>
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-3">
                                <h3 class="text-xl font-bold text-gray-900">{{ $service->name }}</h3>
                                <span class="text-lg font-bold text-teal-600">${{ number_format($service->price, 0) }}</span>
                            </div>

                            <p class="text-gray-600 mb-4">{{ $service->description }}</p>

                            <div class="space-y-2 mb-4">
                                <p class="text-sm text-gray-500">
                                    <span class="font-semibold">⏱️ Duración:</span>
                                    {{ $service->duration }} minutos
                                </p>
                                <p class="text-sm text-gray-500">
                                    <span class="font-semibold">📋 Categoría:</span>
                                    {{ $service->serviceCategory->name }}
                                </p>
                            </div>

                            <a href="{{ route('client.appointments.create', $service) }}" class="block w-full text-center bg-gradient-to-r from-teal-500 to-cyan-600 text-white font-bold py-2 px-4 rounded-lg hover:from-teal-600 hover:to-cyan-700 transition">
                                Agendar Cita
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
