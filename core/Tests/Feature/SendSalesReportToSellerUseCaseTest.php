<?php

namespace Core\Tests\Unit\UseCase;

use Core\Contracts\Repository\OrderRepository;
use Core\Contracts\Repository\SellerRepository;
use Core\Contracts\Services\SalesReportMailService;
use Core\Entity\Dto\SellerSalesReport;
use Core\Entity\Order;
use Core\Exceptions\SellerNotFoundError;
use Core\UseCase\SendSalesReportToSellerUseCase;
use PHPUnit\Framework\TestCase;

class SendSalesReportToSellerUseCaseTest extends TestCase
{
    public function testExecuteSendsSalesReportToSeller()
    {
        // Arrange
        $sellerRepository = $this->createMock(SellerRepository::class);
        $orderRepository = $this->createMock(OrderRepository::class);
        $mailService = $this->createMock(SalesReportMailService::class);

        $input = [
            'seller_id' => 'seller1',
            'date' => '2023-01-01',
        ];

        $orders = [
            new Order(['seller_id' => 'seller1', 'price_in_cents' => 1000, 'payment_approved_at' => '2023-01-01T12:00'], 'order1'),
            new Order(['seller_id' => 'seller1', 'price_in_cents' => 500, 'payment_approved_at' => '2023-01-01T12:00'], 'order2'),
        ];

        $sellerRepository->expects($this->once())
            ->method('existsById')
            ->with('seller1')
            ->willReturn(true);

        $orderRepository->expects($this->once())
            ->method('findByFilters')
            ->with([
                'seller_id' => 'seller1',
                'order_date_between' => ['2023-01-01T00:00:00', '2023-01-01T23:59:59'],
            ])
            ->willReturn($orders);

        $mailService->expects($this->once())
            ->method('sendMail')
            ->with(new SellerSalesReport(1500, 120))
            ->willReturn(new SellerSalesReport(1500, 120)); // Mocking a successful mail service response

        $useCase = new SendSalesReportToSellerUseCase($sellerRepository, $orderRepository, $mailService);

        // Act
        $result = $useCase->execute($input);

        // Assert
        $this->assertIsArray($result);
        // Add more assertions based on your actual implementation and requirements
    }

    public function testExecuteThrowsSellerNotFoundError()
    {
        // Arrange
        $sellerRepository = $this->createMock(SellerRepository::class);
        $orderRepository = $this->createMock(OrderRepository::class);
        $mailService = $this->createMock(SalesReportMailService::class);

        $input = [
            'seller_id' => 'invalid_seller',
            'date' => '2023-01-01',
        ];

        $sellerRepository->expects($this->once())
            ->method('existsById')
            ->with('invalid_seller')
            ->willReturn(false);

        $useCase = new SendSalesReportToSellerUseCase($sellerRepository, $orderRepository, $mailService);

        // Act & Assert
        $this->expectException(SellerNotFoundError::class);
        $useCase->execute($input);
    }

    // Add more test cases as needed
}
