<?php

namespace Core\Exceptions;

use Exception;
use Throwable;

class SellerNotFoundError extends Exception {
    public function __construct(
        Throwable $previous = null,
        $message = null,
        $code = 0,
    ) {
        $message = $message ?? "Nenhum vendedor encontrado com o 'seller_id' informado.";
        parent::__construct($message, $code, $previous);
    }
}
