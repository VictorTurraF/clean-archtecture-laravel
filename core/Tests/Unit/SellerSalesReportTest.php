<?php

namespace Core\Tests\Unit;

use Core\Entity\Dto\SellerSalesReport;
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

        // Act
        $sellerSalesReport = new SellerSalesReport($totalSold, $totalCommission);

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

        // Act & Assert
        $this->expectException(TotalSoldPriceIsInvalidError::class);
        new SellerSalesReport($totalSold, $totalCommission);
    }

    public function testInvalidTotalCommissionPriceThrowsException()
    {
        // Arrange
        $totalSold = 1000;
        $totalCommission = 'invalid_price';

        // Act & Assert
        $this->expectException(TotalCommissionPriceIsInvalidError::class);
        new SellerSalesReport($totalSold, $totalCommission);
    }
}
