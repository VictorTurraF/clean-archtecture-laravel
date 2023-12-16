<?php

namespace Core\Exceptions;

use Exception;
use Throwable;

class OrderPaymentIsInvalidError extends Exception {
    public function __construct(
        $message = null,
        $code = 0,
        Throwable $previous = null
    ) {
        $message = $message ?? "Data do pagamento informado é inválido";
        parent::__construct($message, $code, $previous);
    }
}
