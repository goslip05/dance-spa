<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📦 Mis Órdenes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('client.shop.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    ← Volver a la Tienda
                </a>
            </div>

            @if($orders->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-6xl mb-4">🛒</div>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">No tienes órdenes</h3>
                        <p class="text-gray-500 mb-4">¡Explora nuestra tienda y realiza tu primera compra!</p>
                        <a href="{{ route('client.shop.index') }}" class="inline-flex items-center px-4 py-2 bg-amber-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700">
                            Ir a la Tienda
                        </a>
                    </div>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">Orden {{ $order->order_number }}</h3>
                                        <p class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full
                                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                            {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-700' : '' }}
                                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                            @switch($order->status)
                                                @case('pending') Pendiente @break
                                                @case('processing') Procesando @break
                                                @case('completed') Completada @break
                                                @case('cancelled') Cancelada @break
                                            @endswitch
                                        </span>
                                        <p class="text-xl font-bold text-amber-600 mt-2">${{ number_format($order->total, 0) }}</p>
                                    </div>
                                </div>

                                <div class="border-t pt-4">
                                    <h4 class="font-semibold text-gray-700 mb-3">Items:</h4>
                                    <div class="space-y-2">
                                        @foreach($order->items as $item)
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <p class="text-gray-800">{{ $item->orderable->name ?? 'Producto' }}</p>
                                                    <p class="text-sm text-gray-500">Cantidad: {{ $item->quantity }}</p>
                                                </div>
                                                <p class="font-semibold text-gray-700">${{ number_format($item->subtotal, 0) }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                @if($order->payment_method)
                                    <div class="mt-4 text-sm text-gray-600">
                                        <span class="font-semibold">Método de pago:</span>
                                        @switch($order->payment_method)
                                            @case('cash') Efectivo @break
                                            @case('card') Tarjeta @break
                                            @case('transfer') Transferencia @break
                                            @case('online') Pago en Línea @break
                                            @default {{ $order->payment_method }}
                                        @endswitch
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
