<?php

namespace Core\Exceptions;

use Exception;
use Throwable;

class SellerIdIsInvalidError extends Exception {
    public function __construct(
        Throwable $previous = null,
        $message = null,
        $code = 0,
    ) {
        $message = $message ?? "Id do vendedor informado não pode ser nulo.";
        parent::__construct($message, $code, $previous);
    }
}
