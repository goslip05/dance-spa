<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Services\OrderProcessingService;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct(private OrderProcessingService $orderService)
    {
    }

    public function index()
    {
        $products = Product::where('is_active', true)
            ->orderBy('category')
            ->get()
            ->groupBy('category');

        return view('client.shop.index', compact('products'));
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.orderable')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.shop.my-orders', compact('orders'));
    }
}
