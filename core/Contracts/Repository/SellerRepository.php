<?php

namespace Core\Contracts\Repository;

use Core\Entity\Seller;

interface SellerRepository {

    public function save(Seller $seller): Seller;

    public function existsByEmail(string $sellerEmail): bool;

    public function existsById(string $sellerId): bool;

    public function all(): array;

}
