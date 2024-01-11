<?php

namespace Core\Entity\Dto;

use Core\Entity\ValueObject\Price;
use Core\Exceptions\PriceIsInvalidError;
use Core\Exceptions\TotalCommissionPriceIsInvalidError;
use Core\Exceptions\TotalSoldPriceIsInvalidError;

class SellerSalesReport {
    public Price $totalSold;
    public Price $totalCommission;

    public function __construct(
        $totalSold,
        $totalCommission
    ) {
        $this->totalSold = $this->validateAndCreateTotalSoldPrice($totalSold);
        $this->totalCommission = $this->validateAndCreateTotalCommissionPrice($totalCommission);
    }

    private function validateAndCreateTotalSoldPrice($totalSold) {
        try {
            return new Price($totalSold);
        } catch (PriceIsInvalidError $e) {
            throw new TotalSoldPriceIsInvalidError($e->getMessage());
        }
    }

    private function validateAndCreateTotalCommissionPrice($totalCommission) {
        try {
            return new Price($totalCommission);
        } catch (PriceIsInvalidError $e) {
            throw new TotalCommissionPriceIsInvalidError($e->getMessage());
        }
    }

    public function toArray()
    {
        return [
            "total_sold" => $this->totalSold,
            "total_commission" => $this->totalCommission
        ];
    }
}
