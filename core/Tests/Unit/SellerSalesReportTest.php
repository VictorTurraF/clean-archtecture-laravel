<?php

namespace Core\Tests\Unit;

use Core\Entity\Dto\SellerSalesReport;
use Core\Entity\Seller;
use Core\Entity\ValueObject\Price;
use Core\Exceptions\TotalCommissionPriceIsInvalidError;
use Core\Exceptions\TotalSoldPriceIsInvalidError;
use PHPUnit\Framework\TestCase;

class SellerSalesReportTest extends TestCase
{
    public function testValidSellerSalesReportCreation()
    {
        // Arrange
        $totalSold = 1000;
        $totalCommission = 200;
        $seller = new Seller([
            'name' => 'John',
            'email' => 'john@example.com',
        ]);
        $date = "2024-01-10T00:00";

        // Act
        $sellerSalesReport = new SellerSalesReport($seller, $date, $totalSold, $totalCommission);

        // Assert
        $this->assertInstanceOf(SellerSalesReport::class, $sellerSalesReport);
        $this->assertInstanceOf(Price::class, $sellerSalesReport->totalSold);
        $this->assertInstanceOf(Price::class, $sellerSalesReport->totalCommission);
        $this->assertEquals($totalSold, $sellerSalesReport->totalSold->getInCents());
        $this->assertEquals($totalCommission, $sellerSalesReport->totalCommission->getInCents());
    }

    public function testInvalidTotalSoldPriceThrowsException()
    {
        // Arrange
        $totalSold = 'invalid_price';
        $totalCommission = 200;
        $seller = new Seller([
            'name' => 'John',
            'email' => 'john@example.com',
        ]);
        $date = "2024-01-10T00:00";

        // Act & Assert
        $this->expectException(TotalSoldPriceIsInvalidError::class);
        new SellerSalesReport($seller, $date, $totalSold, $totalCommission);
    }

    public function testInvalidTotalCommissionPriceThrowsException()
    {
        // Arrange
        $totalSold = 1000;
        $totalCommission = 'invalid_price';
        $seller = new Seller([
            'name' => 'John',
            'email' => 'john@example.com',
        ]);
        $date = "2024-01-10T00:00";

        // Act & Assert
        $this->expectException(TotalCommissionPriceIsInvalidError::class);
        new SellerSalesReport($seller, $date, $totalSold, $totalCommission);
    }
}
