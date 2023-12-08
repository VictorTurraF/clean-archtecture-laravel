<?php

namespace Core\Entity\Dto;

use Core\Entity\ValueObject\Email;
use Core\Entity\ValueObject\RequiredString;
use Core\Exceptions\EmailIsInvalidError;
use Core\Exceptions\SellerEmailIsInvalidError;
use Core\Exceptions\SellerNameIsInvalidError;
use Core\Exceptions\StringIsInvalidError;

class SellerProps {
    public RequiredString $name;
    public Email $email;

    public function __construct(
        $name = null,
        $email = null
    ) {
        $this->name = $this->validateAndCreateName($name);
        $this->email = $this->validateAndCreateEmail($email);
    }

    private function validateAndCreateName($name) {
        try {
            return new RequiredString($name);
        } catch (StringIsInvalidError $e) {
            $message = "Nome do vendedor informado é inválido: " . $e->getMessage();
            throw new SellerNameIsInvalidError($e, $message);
        }
    }

    private function validateAndCreateEmail($email) {
        try {
            return new Email($email);
        } catch (EmailIsInvalidError $e) {
            throw new SellerEmailIsInvalidError($e);
        }
    }
}
