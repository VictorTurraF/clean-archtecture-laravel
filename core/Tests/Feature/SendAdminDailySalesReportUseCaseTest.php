<?php

namespace Core\Tests\Unit\UseCase;

use Core\Contracts\DateHelper;
use Core\Contracts\Repository\OrderRepository;
use Core\Contracts\Services\AdminDailySalesReportMailService;
use Core\Entity\Dto\AdminDailySalesReport;
use Core\Entity\Order;
use Core\Exceptions\AdminEmailIsARequiredInputError;
use Core\Exceptions\EmailIsInvalidError;
use Core\Exceptions\InvalidTimeToSendReport;
use Core\Exceptions\PriceIsInvalidError;
use Core\Exceptions\TotalSoldPriceIsInvalidError;
use Core\UseCase\SendAdminDailySalesReportUseCase;
use PHPUnit\Framework\TestCase;

class SendAdminDailySalesReportUseCaseTest extends TestCase
{
    public function testExecuteSendsAdminDailySalesReport()
    {
        // Arrange
        $orderRepository = $this->createMock(OrderRepository::class);
        $mailService = $this->createMock(AdminDailySalesReportMailService::class);
        $dateHelper = $this->createMock(DateHelper::class);

        $input = [
            'admin_email' => 'admin@example.com',
        ];

        $orders = [
            new Order(['seller_id' => 'seller1', 'price_in_cents' => 4000, 'payment_approved_at' => '2023-01-01T12:00'], 'order1'),
            new Order(['seller_id' => 'seller1', 'price_in_cents' => 3000, 'payment_approved_at' => '2023-01-01T12:00'], 'order1'),
        ];

        $dateHelper->expects($this->once())
            ->method('todayAtTheStart')
            ->willReturn('2023-01-01 00:00:00');

        $dateHelper->expects($this->once())
            ->method('todayAtTheEnd')
            ->willReturn('2023-01-01 23:59:59');

        $orderRepository->expects($this->once())
            ->method('findByFilters')
            ->with(['order_date_between' => ['2023-01-01 00:00:00', '2023-01-01 23:59:59']])
            ->willReturn($orders);


        $report = new AdminDailySalesReport(7000, 'admin@example.com');

        $mailService->expects($this->once())
            ->method('sendMail')
            ->with($report)
            ->willReturn($report); // Mocking a successful mail service response

        $useCase = new SendAdminDailySalesReportUseCase($orderRepository, $mailService, $dateHelper);

        // Act
        $result = $useCase->execute($input);

        // Assert
        $this->assertIsArray($result);
        // Add more assertions based on your actual implementation and requirements
    }

    public function testExecuteThrowsAdminEmailRequiredError()
    {
        // Arrange
        $orderRepository = $this->createMock(OrderRepository::class);
        $mailService = $this->createMock(AdminDailySalesReportMailService::class);
        $dateHelper = $this->createMock(DateHelper::class);

        $input = [];

        $useCase = new SendAdminDailySalesReportUseCase($orderRepository, $mailService, $dateHelper);

        // Act & Assert
        $this->expectException(AdminEmailIsARequiredInputError::class);
        $useCase->execute($input);
    }

    // Add more test cases as needed
}
