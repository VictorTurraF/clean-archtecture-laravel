<?php

namespace Core\Entity\Dto;

use Core\Entity\ValueObject\Email;
use Core\Entity\ValueObject\Price;
use Core\Exceptions\AdminEmailIsInvalidError;
use Core\Exceptions\EmailIsInvalidError;
use Core\Exceptions\PriceIsInvalidError;
use Core\Exceptions\TotalSoldPriceIsInvalidError;

class AdminDailySalesReport {
    public Price $totalSold;
    public Email $adminEmail;

    public function __construct(
        $totalSold,
        $adminEmail
    ) {
        $this->totalSold = $this->validateAndCreateTotalSoldPrice($totalSold);
        $this->adminEmail = $this->validateAndCreateAdminEmail($adminEmail);
    }

    private function validateAndCreateTotalSoldPrice($totalSold) {
        try {
            return new Price($totalSold);
        } catch (PriceIsInvalidError $e) {
            throw new TotalSoldPriceIsInvalidError($e->getMessage());
        }
    }

    private function validateAndCreateAdminEmail($adminEmail) {
        try {
            return new Email($adminEmail);
        } catch (EmailIsInvalidError $e) {
            throw new AdminEmailIsInvalidError($e->getMessage());
        }
    }

    public function toArray() {
        return [
            'total_sold' => $this->totalSold,
            'admin_email' => $this->adminEmail
        ];
    }
}
