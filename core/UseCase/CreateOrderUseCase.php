<?php

namespace Core\UseCase;

use Core\Contracts\Repository\OrderRepository;
use Core\Contracts\Repository\SellerRepository;
use Core\Contracts\UseCase;
use Core\Entity\Order;
use Core\Exceptions\SellerNotFoundError;

class CreateOrderUseCase implements UseCase {
    public function __construct(
        private SellerRepository $sellerRepo,
        private OrderRepository $orderRepo
    ) {}

    public function execute($input): mixed
    {
        if ($this->sellerRepo->existsById($input['seller_id']))
            throw new SellerNotFoundError();

        $order = new Order([
            'seller_id' => $input['seller_id'],
            'price_in_cents' => $input['price_in_cents'],
            'payment_approved_at' => $input['payment_approved_at'],
        ]);

        $createdOrder = $this->orderRepo->save($order);

        return $createdOrder->toArray();
    }
}
