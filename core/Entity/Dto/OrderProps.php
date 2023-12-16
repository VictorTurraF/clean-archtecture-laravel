<?php

namespace Core\Entity\Dto;

use Core\Entity\ValueObject\IsoDate;
use Core\Entity\ValueObject\Price;
use Core\Entity\ValueObject\RequiredString;

use Core\Exceptions\DateIsoIsInvalidError;
use Core\Exceptions\OrderPaymentIsInvalidError;
use Core\Exceptions\OrderPriceIsInvalidError;
use Core\Exceptions\PriceIsInvalidError;
use Core\Exceptions\SellerIdIsInvalidError;
use Core\Exceptions\StringIsInvalidError;

class OrderProps {
    public RequiredString $sellerId;
    public Price $priceInCents;
    public IsoDate $paymentApprovedAt;

    public function __construct(
        $sellerId = null,
        $priceInCents = null,
        $paymentApprovedAt = null
    ) {
        $this->sellerId = $this->validateAndCreateSellerId($sellerId);
        $this->priceInCents = $this->validateAndCreatePrice($priceInCents);
        $this->paymentApprovedAt = $this->validateAndCreatePaymentDate($paymentApprovedAt);
    }

    private function validateAndCreateSellerId($sellerId) {
        try {
            return new RequiredString($sellerId);
        } catch (StringIsInvalidError) {
            throw new SellerIdIsInvalidError();
        }
    }

    private function validateAndCreatePrice($priceInCents) {
        try {
            return new Price($priceInCents);
        } catch (PriceIsInvalidError) {
            throw new OrderPriceIsInvalidError();
        }
    }

    private function validateAndCreatePaymentDate($paymentDate) {
        try {
            return new IsoDate($paymentDate);
        } catch (DateIsoIsInvalidError) {
            throw new OrderPaymentIsInvalidError();
        }
    }
}
