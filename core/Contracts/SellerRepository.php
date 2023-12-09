<?php

namespace Core\Contracts;

use Core\Entity\Seller;

interface SellerRepository {

    public function save(): Seller;

    public function existsByEmail(): bool;

    public function all(): array;

}
