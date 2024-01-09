<?php

namespace Core\Tests\Unit;

use Core\Entity\Dto\AdminDailySalesReport;
use Core\Entity\ValueObject\Email;
use Core\Entity\ValueObject\Price;
use Core\Exceptions\AdminEmailIsInvalidError;
use Core\Exceptions\TotalSoldPriceIsInvalidError;
use PHPUnit\Framework\TestCase;

class AdminDailySalesReportTest extends TestCase
{
    public function testValidAdminDailySalesReportCreation()
    {
        // Arrange
        $totalSold = 1000;
        $adminEmail = 'admin@example.com';

        // Act
        $adminDailySalesReport = new AdminDailySalesReport($totalSold, $adminEmail);

        // Assert
        $this->assertInstanceOf(AdminDailySalesReport::class, $adminDailySalesReport);
        $this->assertInstanceOf(Price::class, $adminDailySalesReport->totalSold);
        $this->assertInstanceOf(Email::class, $adminDailySalesReport->adminEmail);
        $this->assertEquals($totalSold, $adminDailySalesReport->totalSold->getInCents());
        $this->assertEquals($adminEmail, $adminDailySalesReport->adminEmail->getAddress());
    }

    public function testInvalidTotalSoldPriceThrowsException()
    {
        // Arrange
        $totalSold = 'invalid_price';
        $adminEmail = 'admin@example.com';

        // Act & Assert
        $this->expectException(TotalSoldPriceIsInvalidError::class);
        new AdminDailySalesReport($totalSold, $adminEmail);
    }

    public function testInvalidAdminEmailThrowsException()
    {
        // Arrange
        $totalSold = 1000;
        $adminEmail = 'invalid_email';

        // Act & Assert
        $this->expectException(AdminEmailIsInvalidError::class);
        new AdminDailySalesReport($totalSold, $adminEmail);
    }
}
