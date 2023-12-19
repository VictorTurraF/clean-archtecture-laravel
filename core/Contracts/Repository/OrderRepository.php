<?php

namespace Core\Contracts\Repository;

use Core\Entity\Order;

interface OrderRepository {

    function existsById($sellerId): bool;

    function save($input): Order;

}
