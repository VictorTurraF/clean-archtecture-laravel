<?php

namespace Core\Exceptions;

use Exception;
use Throwable;

class AdminEmailIsInvalidError extends Exception {
    public function __construct(
        $message = null,
        $code = 0,
        Throwable $previous = null
    ) {
        $message = "Email do administrador é inválido para o relatório de vendas. {$message}";
        parent::__construct($message, $code, $previous);
    }
}
