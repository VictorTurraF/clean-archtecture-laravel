<?php

namespace Core\Exceptions;

use Core\Exceptions\EmailIsInvalidError;
use Exception;

class SellerEmailIsInvalidError extends EmailIsInvalidError {
    public function __construct() {
        parent::__construct("Email do vendedor informado é inválido");
    }
}
