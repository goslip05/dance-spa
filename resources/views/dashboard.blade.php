<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Bienvenida -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-white">
                    <h3 class="text-2xl font-bold mb-2">¡Bienvenido, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-indigo-100">
                        @hasrole('Super Admin|Administrador')
                            Panel de administración del Centro Wellness Dance & Spa
                        @elsehasrole('Profesional')
                            Aquí puedes gestionar tu agenda y ver tus clases programadas
                        @elsehasrole('Cliente')
                            Explora nuestras clases, servicios de spa y productos
                        @endhasrole
                    </p>
                </div>
            </div>

            <!-- Dashboard para Super Admin y Administrador -->
            @hasanyrole('Super Admin|Administrador')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Panel Admin</p>
                                    <p class="text-2xl font-bold text-gray-900">Filament</p>
                                </div>
                                <div class="text-4xl">⚙️</div>
                            </div>
                            <a href="/admin" class="mt-4 block w-full text-center bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                                Ir al Panel
                            </a>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Gestión</p>
                                    <p class="text-2xl font-bold text-gray-900">Completa</p>
                                </div>
                                <div class="text-4xl">📊</div>
                            </div>
                            <div class="mt-4 text-sm text-gray-600">
                                Usuarios, servicios, citas y más
                            </div>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Sistema</p>
                                    <p class="text-2xl font-bold text-gray-900">Activo</p>
                                </div>
                                <div class="text-4xl">✅</div>
                            </div>
                            <div class="mt-4 text-sm text-gray-600">
                                Todo funcionando correctamente
                            </div>
                        </div>
                    </div>
                </div>
            @endhasanyrole

            <!-- Dashboard para Profesional -->
            @hasrole('Profesional')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">📅 Mi Agenda</h4>
                            <p class="text-gray-600 mb-4">Gestiona tus citas y clases programadas</p>
                            <a href="{{ route('professional.agenda.index') }}" class="block w-full text-center bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                                Ver Agenda
                            </a>
                        </div>
                    </div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">👥 Mis Clases</h4>
                            <p class="text-gray-600 mb-4">Revisa tus horarios y estudiantes inscritos</p>
                            <a href="{{ route('professional.agenda.index') }}" class="block w-full text-center bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition">
                                Ver Clases
                            </a>
                        </div>
                    </div>
                </div>
            @endhasrole

            <!-- Dashboard para Cliente -->
            @hasrole('Cliente')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                        <div class="p-6">
                            <div class="text-5xl mb-4 text-center">💃</div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2 text-center">Clases de Baile</h4>
                            <p class="text-gray-600 mb-4 text-center text-sm">Salsa, Bachata, Tango y más</p>
                            <a href="{{ route('client.classes.index') }}" class="block w-full text-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition">
                                Ver Clases
                            </a>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                        <div class="p-6">
                            <div class="text-5xl mb-4 text-center">💆</div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2 text-center">Servicios de Spa</h4>
                            <p class="text-gray-600 mb-4 text-center text-sm">Masajes, faciales y tratamientos</p>
                            <a href="{{ route('client.appointments.index') }}" class="block w-full text-center bg-gradient-to-r from-teal-500 to-cyan-600 text-white py-2 rounded-lg hover:from-teal-600 hover:to-cyan-700 transition">
                                Ver Servicios
                            </a>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                        <div class="p-6">
                            <div class="text-5xl mb-4 text-center">🛍️</div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2 text-center">Tienda</h4>
                            <p class="text-gray-600 mb-4 text-center text-sm">Productos, paquetes y membresías</p>
                            <a href="{{ route('client.shop.index') }}" class="block w-full text-center bg-gradient-to-r from-amber-500 to-orange-600 text-white py-2 rounded-lg hover:from-amber-600 hover:to-orange-700 transition">
                                Ir a la Tienda
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Accesos Rápidos -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">⚡ Accesos Rápidos</h4>
                            <div class="space-y-2">
                                <a href="{{ route('client.classes.my-classes') }}" class="block px-4 py-2 bg-gray-100 rounded hover:bg-gray-200 transition">
                                    📚 Mis Clases Inscritas
                                </a>
                                <a href="{{ route('client.appointments.my-appointments') }}" class="block px-4 py-2 bg-gray-100 rounded hover:bg-gray-200 transition">
                                    📋 Mis Citas Agendadas
                                </a>
                                <a href="{{ route('client.shop.my-orders') }}" class="block px-4 py-2 bg-gray-100 rounded hover:bg-gray-200 transition">
                                    📦 Mis Órdenes
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-2">💫 ¡Descubre el Wellness!</</h4>
                            <p class="text-gray-700 text-sm">
                                Combina baile y relajación para un estilo de vida saludable.
                                Inscríbete a nuestras clases y reserva tus tratamientos de spa.
                            </p>
                        </div>
                    </div>
                </div>
            @endhasrole
        </div>
    </div>
</x-app-layout>
