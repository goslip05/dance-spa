<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Servicio para procesar órdenes de compra
 */
class OrderProcessingService
{
    /**
     * Crear una nueva orden
     */
    public function createOrder(User $user, array $items, string $orderType, ?string $paymentMethod = null): Order
    {
        return DB::transaction(function () use ($user, $items, $orderType, $paymentMethod) {
            // Crear la orden
            $order = Order::create([
                'user_id' => $user->id,
                'order_type' => $orderType,
                'payment_method' => $paymentMethod,
                'status' => 'pending',
                'total' => 0,
            ]);

            $total = 0;

            // Agregar items
            foreach ($items as $item) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'orderable_type' => $item['type'],
                    'orderable_id' => $item['id'],
                    'quantity' => $item['quantity'] ?? 1,
                    'price' => $item['price'],
                ]);

                $total += $orderItem->subtotal;
            }

            // Actualizar total de la orden
            $order->update(['total' => $total]);

            return $order->fresh('items');
        });
    }

    /**
     * Procesar el pago de una orden
     */
    public function processPayment(Order $order, string $paymentMethod): bool
    {
        // Aquí iría la lógica de integración con pasarela de pago
        // Por ahora solo actualizamos el estado

        $order->update([
            'payment_method' => $paymentMethod,
            'status' => 'processing',
        ]);

        return true;
    }

    /**
     * Completar una orden
     */
    public function completeOrder(Order $order): bool
    {
        $order->status = 'completed';
        return $order->save();
    }

    /**
     * Cancelar una orden
     */
    public function cancelOrder(Order $order): bool
    {
        if ($order->status === 'completed') {
            throw new \Exception('No se puede cancelar una orden completada');
        }

        $order->status = 'cancelled';
        return $order->save();
    }

    /**
     * Obtener historial de órdenes del usuario
     */
    public function getUserOrders(User $user)
    {
        return $user->orders()
            ->with('items.orderable')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
