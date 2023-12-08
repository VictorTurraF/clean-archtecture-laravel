<?php

namespace Core\Exceptions;

use Exception;
use Throwable;

class StringIsInvalidError extends Exception {
    public function __construct(
        $message = null,
        $code = 0,
        Throwable $previous = null
    ) {
        $message = $message ?? "Valor informado para string é inválido.";
        parent::__construct($message, $code, $previous);
    }
}
