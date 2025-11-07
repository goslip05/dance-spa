<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🛍️ Tienda
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('client.shop.my-orders') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Ver Mis Órdenes
                </a>
            </div>

            @foreach($products as $category => $categoryProducts)
                <div class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        @switch($category)
                            @case('memberships') 🏅 Membresías @break
                            @case('packages') 📦 Paquetes @break
                            @case('cosmetics') 💄 Cosméticos @break
                            @case('merchandising') 👕 Merchandising @break
                            @default {{ $category }}
                        @endswitch
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($categoryProducts as $product)
                            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg hover:shadow-xl transition transform hover:-translate-y-1">
                                <div class="h-48 bg-gradient-to-br from-amber-400 to-orange-600 flex items-center justify-center">
                                    <span class="text-6xl">
                                        @switch($category)
                                            @case('memberships') 🏅 @break
                                            @case('packages') 📦 @break
                                            @case('cosmetics') 💄 @break
                                            @case('merchandising') 👕 @break
                                        @endswitch
                                    </span>
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="text-lg font-bold text-gray-900">{{ $product->name }}</h3>
                                    </div>

                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product->description }}</p>

                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-xl font-bold text-amber-600">${{ number_format($product->price, 0) }}</span>
                                        <span class="text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $product->stock > 0 ? "Stock: {$product->stock}" : 'Agotado' }}
                                        </span>
                                    </div>

                                    @if($product->stock > 0)
                                        <button class="w-full bg-gradient-to-r from-amber-500 to-orange-600 text-white font-bold py-2 px-4 rounded-lg hover:from-amber-600 hover:to-orange-700 transition">
                                            Agregar al Carrito
                                        </button>
                                    @else
                                        <button disabled class="w-full bg-gray-300 text-gray-500 font-bold py-2 px-4 rounded-lg cursor-not-allowed">
                                            Agotado
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
