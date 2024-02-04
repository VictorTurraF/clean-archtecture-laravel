<?php

namespace Core\Tests\Feature;

use Core\Contracts\DateHelper;
use Core\Contracts\Repository\OrderRepository;
use Core\Contracts\Repository\SellerRepository;
use Core\Contracts\Services\SalesReportMailService;
use Core\Entity\Dto\SellerSalesReport;
use Core\Entity\Order;
use Core\Entity\Seller;
use Core\Exceptions\InvalidTimeToSendReport;
use Core\UseCase\SendSalesReportEmailToAllSellersUseCase;
use PHPUnit\Framework\TestCase;

class SendSalesReportEmailToAllSellersUseCaseTest extends TestCase
{
    public function testExecuteSendsEmailsToAllSellers()
    {
        // Arrange
        $salesReportMailService = $this->createMock(SalesReportMailService::class);
        $sellerRepository = $this->createMock(SellerRepository::class);
        $orderRepository = $this->createMock(OrderRepository::class);
        $dateHelper = $this->createMock(DateHelper::class);

        $sellers = [
            // Mock seller data
            new Seller(['name' => "John", 'email' => "john@example.com"], 'seller1'),
            new Seller(['name' => "Sara", 'email' => "sara@example.com"], 'seller2'),
        ];

        $dateHelper->expects($this->once())
            ->method('isEndOfTheDay')
            ->willReturn(true);

        $sellerRepository->expects($this->once())
            ->method('all')
            ->willReturn($sellers);

        $orderRepository->expects($this->exactly(count($sellers)))
            ->method('findByFilters')
            ->willReturn(
                [
                    new Order(['seller_id' => 'seller1', 'price_in_cents' => 1000, 'payment_approved_at' => '2023-01-01T12:00'], 'order1'),
                    new Order(['seller_id' => 'seller1', 'price_in_cents' => 500, 'payment_approved_at' => '2023-01-01T12:00'], 'order2'),
                ],
                [
                    new Order(['seller_id' => 'seller2', 'price_in_cents' => 700, 'payment_approved_at' => '2023-01-01T12:00'], 'order3'),
                    new Order(['seller_id' => 'seller2', 'price_in_cents' => 700, 'payment_approved_at' => '2023-01-01T12:00'], 'order4'),
                ]
            );

        $salesReportMailService->expects($this->exactly(count($sellers)))
            ->method('sendMail')
            ->willReturn(
                new SellerSalesReport($sellers[0], "2023-01-01T00:00", 1500, 120),
                new SellerSalesReport($sellers[1], "2023-01-01T00:00", 1400, 112)
            );

        $dateHelper->expects($this->exactly(4))
            ->method('todayAtTheStart')
            ->willReturn(
                "2023-01-01T00:00",
                "2023-01-01T00:00",
                "2023-01-01T00:00",
                "2023-01-01T00:00"
            );

        $useCase = new SendSalesReportEmailToAllSellersUseCase(
            $salesReportMailService,
            $sellerRepository,
            $orderRepository,
            $dateHelper
        );

        // Act
        $useCase->execute();

        // Assert
        $this->assertTrue(true); // Placeholder assertion, as we are testing method calls on mocks
    }

    public function testExecuteThrowsExceptionOutsideValidTime()
    {
        // Arrange
        $salesReportMailService = $this->createMock(SalesReportMailService::class);
        $sellerRepository = $this->createMock(SellerRepository::class);
        $orderRepository = $this->createMock(OrderRepository::class);
        $dateHelper = $this->createMock(DateHelper::class);

        $dateHelper->expects($this->once())
            ->method('isEndOfTheDay')
            ->willReturn(false); // Mocking that it's not the end of the day

        $useCase = new SendSalesReportEmailToAllSellersUseCase(
            $salesReportMailService,
            $sellerRepository,
            $orderRepository,
            $dateHelper
        );

        // Act & Assert
        $this->expectException(InvalidTimeToSendReport::class);

        $useCase->execute();
    }

    // Add more test cases as needed
}
