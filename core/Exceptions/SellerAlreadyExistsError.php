<?php

namespace Core\Exceptions;

use Exception;
use Throwable;

class SellerAlreadyExistsError extends Exception {
    public function __construct(
        $message = null,
        $code = 0,
        Throwable $previous = null
    ) {
        $message = $message ?? "Já existe um vendedor cadastrado com este email";
        parent::__construct($message, $code, $previous);
    }
}
