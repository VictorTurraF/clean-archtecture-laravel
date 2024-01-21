<?php

namespace Core\Contracts\Repository;

use Core\Entity\Order;

interface OrderRepository {

    function all(): array;

    function existsById($sellerId): bool;

    function create($input): Order;

    function findBySellerId($sellerId): array;

    function findByFilters(array $filters): array;

}
