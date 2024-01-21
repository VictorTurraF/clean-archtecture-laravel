<?php

namespace Core\UseCase;

use Core\Contracts\Repository\SellerRepository;
use Core\Contracts\UseCase;
use Core\Entity\Seller;

class ListAllSellersUseCase implements UseCase {
    public function __construct(
        private SellerRepository $sellerRepo
    ) {}

    public function execute($input = []): mixed
    {
        $allSellers = $this->sellerRepo->all();

        $arrayResult = array_map(
            fn(Seller $seller): array => $seller->toArray(),
            $allSellers
        );

        return $arrayResult;
    }
}
