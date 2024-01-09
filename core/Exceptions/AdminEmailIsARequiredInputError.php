<?php

namespace Core\Exceptions;

use Exception;
use Throwable;

class AdminEmailIsARequiredInputError extends Exception {
    public function __construct(
        $message = null,
        $code = 0,
        Throwable $previous = null
    ) {
        $message = "Email do administrador é obrigatório para envio do relatório de vendas. {$message}";
        parent::__construct($message, $code, $previous);
    }
}
