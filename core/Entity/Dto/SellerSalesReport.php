<?php

namespace Core\Entity\Dto;

use Core\Entity\Seller;
use Core\Entity\ValueObject\IsoDate;
use Core\Entity\ValueObject\Price;
use Core\Exceptions\DateIsoIsInvalidError;
use Core\Exceptions\PriceIsInvalidError;
use Core\Exceptions\ReportDateIsInvalidError;
use Core\Exceptions\TotalCommissionPriceIsInvalidError;
use Core\Exceptions\TotalSoldPriceIsInvalidError;

class SellerSalesReport {

    public Seller $seller;
    public IsoDate $date; // added

    public Price $totalSold;
    public Price $totalCommission;

    public function __construct(
        $seller,
        $date,
        $totalSold,
        $totalCommission
    ) {
        $this->seller = $seller;
        $this->date = $this->validateAndCreateIsoDate($date);
        $this->totalSold = $this->validateAndCreateTotalSoldPrice($totalSold);
        $this->totalCommission = $this->validateAndCreateTotalCommissionPrice($totalCommission);
    }

    private function validateAndCreateIsoDate($date) {
        try {
            return new IsoDate($date);
        } catch (DateIsoIsInvalidError $e) {
            throw new ReportDateIsInvalidError();
        }
    }

    private function validateAndCreateTotalSoldPrice($totalSold) {
        try {
            return new Price($totalSold);
        } catch (PriceIsInvalidError $e) {
            throw new TotalSoldPriceIsInvalidError("Invalid total sold price: " .$e->getMessage());
        }
    }

    private function validateAndCreateTotalCommissionPrice($totalCommission) {
        try {
            return new Price($totalCommission);
        } catch (PriceIsInvalidError $e) {
            throw new TotalCommissionPriceIsInvalidError("Invalid total commission price: " .$e->getMessage());
        }
    }

    public function toArray()
    {
        return [
            "seller" => $this->seller->toArray(),
            "date" => (string) $this->date,
            "total_sold" => (string) $this->totalSold,
            "total_commission" => (string) $this->totalCommission
        ];
    }
}
