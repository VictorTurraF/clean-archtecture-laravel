<?php

namespace App\External\Repository;

use Core\Contracts\Repository\OrderRepository;
use Core\Entity\Order as CoreOrder;
use App\Models\Order;

class EloquentOrderRepository implements OrderRepository
{
    public function all(): array
    {
        $orders = Order::all();

        return $orders
            ->map(fn (Order $order) => $this->mapOrderToCoreOrder($order))
            ->toArray();
    }

    public function existsById($orderId): bool
    {
        return Order::where('id', $orderId)->exists();
    }

    public function create(CoreOrder $coreOrder): CoreOrder
    {
        $order = Order::create([
            'seller_id' => (string) $coreOrder->props()->sellerId,
            'price_in_cents' => $coreOrder->props()->priceInCents->getInCents(),
            'payment_approved_at' => $coreOrder->props()->paymentApprovedAt->getIsoDate()
        ]);

        $coreOrder->setId($order->id);

        return $coreOrder;
    }

    public function findBySellerId($sellerId): array
    {
        $orders = Order::where('seller_id', $sellerId)->get();

        return $orders
            ->map(fn (Order $order) => $this->mapOrderToCoreOrder($order))
            ->toArray();
    }

    public function findByFilters(array $filters): array
    {
        $orderQuery = Order::query();

        if (isset($filters['seller_id'])) {
            $orderQuery->where('seller_id', $filters['seller_id']);
        }

        if (isset($filters['order_date_between'])) {
            $orderQuery->where('payment_approved_at', $filters['order_date_between']);
        }

        return $orderQuery
            ->get()
            ->map(fn (Order $order) => $this->mapOrderToCoreOrder($order))
            ->toArray();
    }

    private function mapOrderToCoreOrder(Order $order): CoreOrder
    {
        return new CoreOrder([
            'seller_id' => $order->seller_id,
            'price_in_cents' => $order->price_in_cents,
            'payment_approved_at' => $order->payment_approved_at->format("Y-m-d\TH:i")
        ], $order->id);
    }
}
