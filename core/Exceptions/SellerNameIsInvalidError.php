<?php

namespace Core\Exceptions;

use Exception;
use Throwable;

class SellerNameIsInvalidError extends Exception {
    public function __construct(
        $message = null,
        Throwable $previous = null,
        $code = 0,
    ) {
        $message = $message ?? "Nome do vendedor é inválido.";
        parent::__construct($message, $code, $previous);
    }
}
