<?php

namespace Core\Exceptions;

use Exception;
use Throwable;

class TotalSoldPriceIsInvalidError extends Exception {
    public function __construct(
        $message = null,
        $code = 0,
        Throwable $previous = null
    ) {
        $message = "Valor de total de vendas para relatiório de vendas é inválido. $message";
        parent::__construct($message, $code, $previous);
    }
}
