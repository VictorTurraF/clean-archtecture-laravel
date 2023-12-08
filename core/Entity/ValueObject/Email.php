<?php

namespace Core\Entity\ValueObject;

use Core\Exceptions\EmailIsInvalidError;

class Email {
    private string $address;

    public function __construct(string $address = null)
    {
        $this->validate($address);
        $this->address = $address;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    private function validate(string $address = null): void
    {
        // Basic email validation
        if (!filter_var($address, FILTER_VALIDATE_EMAIL)) {
            throw new EmailIsInvalidError("Invalid email address: $address");
        }
    }

    public function __toString(): string
    {
        return $this->address;
    }
}
