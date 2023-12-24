<?php

namespace Core\Contracts\Repository;

use Core\Entity\Order;

interface OrderRepository {

    function all(): array;

    function existsById($sellerId): bool;

    function save($input): Order;

    function findBySellerId($sellerId): array;

}
