<?php

namespace Core\Tests\Unit;

use Core\Contracts\Repository\OrderRepository;
use Core\Contracts\Repository\SellerRepository;
use Core\Entity\Order;
use Core\Exceptions\SellerNotFoundError;
use Core\UseCase\ListAllOrdersBySellerUseCase;
use PHPUnit\Framework\TestCase;

class ListAllOrdersBySellerUseCaseTest extends TestCase
{
    public function testExecuteReturnsArrayOfOrdersForSeller()
    {
        // Arrange
        $sellerId = 'seller123';
        $order1 = new Order(['seller_id' => $sellerId, 'price_in_cents' => 1000, 'payment_approved_at' => '2023-01-01T12:00'], 'order123');
        $order2 = new Order(['seller_id' => $sellerId, 'price_in_cents' => 1500, 'payment_approved_at' => '2023-02-01T14:30'], 'order456');

        $orderRepository = $this->createMock(OrderRepository::class);
        $orderRepository->expects($this->once())
            ->method('findBySellerId')
            ->with($sellerId)
            ->willReturn([$order1, $order2]);

        $sellerRepository = $this->createMock(SellerRepository::class);
        $sellerRepository->expects($this->once())
            ->method('existsById')
            ->with($sellerId)
            ->willReturn(true);

        $listAllOrdersBySellerUseCase = new ListAllOrdersBySellerUseCase($orderRepository, $sellerRepository);

        // Act
        $result = $listAllOrdersBySellerUseCase->execute($sellerId);

        // Assert
        $expectedResult = [
            [
                'id' => 'order123',
                'seller_id' => $sellerId,
                'price' => [
                    'in_cents' => 1000,
                    'formatted' => 'R$ 10,00',
                ],
                'payment_approved_at' => [
                    'iso_date' => '2023-01-01T12:00',
                    'formatted' => "01/01/2023 12:00",
                ],
            ],
            [
                'id' => 'order456',
                'seller_id' => $sellerId,
                'price' => [
                    'in_cents' => 1500,
                    'formatted' => 'R$ 15,00',
                ],
                'payment_approved_at' => [
                    'iso_date' => '2023-02-01T14:30',
                    'formatted' => "01/02/2023 14:30",
                ],
            ],
        ];

        $this->assertEquals($expectedResult, $result);
    }

    public function testExecuteThrowsSellerNotFoundErrorForNonExistingSeller()
    {
        // Arrange
        $sellerId = 'nonExistingSeller';

        $orderRepository = $this->createMock(OrderRepository::class);
        $sellerRepository = $this->createMock(SellerRepository::class);
        $sellerRepository->expects($this->once())
            ->method('existsById')
            ->with($sellerId)
            ->willReturn(false);

        $listAllOrdersBySellerUseCase = new ListAllOrdersBySellerUseCase($orderRepository, $sellerRepository);

        // Act & Assert
        $this->expectException(SellerNotFoundError::class);
        $listAllOrdersBySellerUseCase->execute($sellerId);
    }
}
