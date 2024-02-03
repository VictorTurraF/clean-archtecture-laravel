<?php

namespace Core\UseCase;

use Core\Contracts\Repository\OrderRepository;
use Core\Contracts\UseCase;
use Core\Entity\Order;

class ListAllOrdersUseCase implements UseCase {
    public function __construct(
        private OrderRepository $orderRepo
    ) {}

    public function execute($input = null):mixed
    {
        $allOrders = $this->orderRepo->all();

        $arrayResult = array_map(
            fn(Order $seller): array => $seller->toArray(),
            $allOrders
        );

        return $arrayResult;
    }
}
