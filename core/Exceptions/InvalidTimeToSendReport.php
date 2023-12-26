<?php

namespace Core\Exceptions;

use Exception;
use Throwable;

class InvalidTimeToSendReport extends Exception {
    public function __construct(
        Throwable $previous = null,
        $message = null,
        $code = 0,
    ) {
        $message = $message ?? "O Relatório só pode ser enviado após as 19h e até as 23h do mesmo dia.";
        parent::__construct($message, $code, $previous);
    }
}
