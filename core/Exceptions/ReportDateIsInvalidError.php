<?php

namespace Core\Exceptions;

use Exception;
use Throwable;

class ReportDateIsInvalidError extends Exception {
    public function __construct(
        $message = null,
        $code = 0,
        Throwable $previous = null
    ) {
        $message = $message ?? "Data informada para o relatório de vendas é invalida.";
        parent::__construct($message, $code, $previous);
    }
}
