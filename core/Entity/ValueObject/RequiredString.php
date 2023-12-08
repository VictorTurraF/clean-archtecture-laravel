<?php

namespace Core\Entity\ValueObject;

use Core\Exceptions\StringIsInvalidError;

class RequiredString
{
    private $value;

    public function __construct(string $value = null)
    {
        $this->validateString($value);

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function validateString(string $value = null): void
    {
        if ($value === null) {
            throw new StringIsInvalidError("Valor informado para string não pode ser nulo");
        }

        if (strlen($value) < 3) {
            throw new StringIsInvalidError("A String deve ter um tamanho mínimo de 3 characters");
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }
}

?>
