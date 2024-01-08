<?php

namespace Core\Entity\ValueObject;

use Core\Exceptions\PriceIsInvalidError;

class Price {
    private int $amountInCents;

    public function __construct($amountInCents) {
        $this->validate($amountInCents);
        $this->amountInCents = $amountInCents;
    }

    public function getInCents() {
        return $this->amountInCents;
    }

    public function getInFloat() {
        return $this->amountInCents / 100.0;
    }

    private function validate($amountInCents) {
        if ($amountInCents === null) {
            throw new PriceIsInvalidError("Valor de preço informado não pode ser nulo.");
        }

        if (!is_int($amountInCents)) {
            throw new PriceIsInvalidError("Valor de preço informado deve ser do tipo numérico.");
        }

        if ($amountInCents < 0) {
            throw new PriceIsInvalidError("Valor de preço informado não poder ser negativo.");
        }
    }

    public function __toString()
    {
        return "R$ ".number_format($this->amountInCents / 100.0, 2, ",", ".");
    }
}
