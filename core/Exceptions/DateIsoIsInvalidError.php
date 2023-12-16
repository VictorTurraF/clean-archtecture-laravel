<?php

namespace Core\Exceptions;

use Exception;
use Throwable;

class DateIsoIsInvalidError extends Exception {
    public function __construct(
        $message = null,
        $code = 0,
        Throwable $previous = null
    ) {
        $message = $message ?? "Data informada não está no formato ISO. O formato válido é YYYY-MM-DDTHH:mm .";
        parent::__construct($message, $code, $previous);
    }
}
