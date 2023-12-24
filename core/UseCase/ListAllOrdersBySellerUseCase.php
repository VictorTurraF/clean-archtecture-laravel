<?php

namespace Core\UseCase;

use Core\Contracts\Repository\OrderRepository;
use Core\Contracts\Repository\SellerRepository;
use Core\Exceptions\SellerNotFoundError;

class ListAllOrdersBySellerUseCase
{
    public function __construct(
        private OrderRepository $orderRepository,
        private SellerRepository $sellerRepository,
    ) {}

    public function execute(string $sellerId): array
    {
        if (!$this->sellerRepository->existsById($sellerId))
            throw new SellerNotFoundError();

        $orders = $this->orderRepository->findBySellerId($sellerId);

        $result = array_map(
            fn ($order) => $order->toArray(),
            $orders
        );

        return $result;
    }
}
