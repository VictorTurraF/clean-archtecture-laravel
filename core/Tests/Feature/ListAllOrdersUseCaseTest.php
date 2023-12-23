<?php

namespace Core\Tests\Feature;

use Core\Contracts\Repository\OrderRepository;
use Core\Entity\Order;
use Core\UseCase\ListAllOrdersUseCase;
use PHPUnit\Framework\TestCase;

class ListAllOrdersUseCaseTest extends TestCase
{
    public function testExecuteReturnsArrayOfOrders()
    {
        // Arrange
        $order1 = new Order(['seller_id' => 'seller123', 'price_in_cents' => 1000, 'payment_approved_at' => '2023-01-01T12:00'], 'order123');
        $order2 = new Order(['seller_id' => 'seller456', 'price_in_cents' => 1500, 'payment_approved_at' => '2023-02-01T14:30'], 'order456');

        $orderRepository = $this->createMock(OrderRepository::class);
        $orderRepository->expects($this->once())
            ->method('all')
            ->willReturn([$order1, $order2]);

        $listAllOrdersUseCase = new ListAllOrdersUseCase($orderRepository);

        // Act
        $result = $listAllOrdersUseCase->execute([]);

        // Assert
        $expectedResult = [
            [
                'id' => 'order123',
                'seller_id' => 'seller123',
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
                'seller_id' => 'seller456',
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

    // Add more test cases as needed
    public function testExecuteReturnsEmptyArrayForNoOrders()
    {
        // Arrange
        $orderRepository = $this->createMock(OrderRepository::class);
        $orderRepository->expects($this->once())
            ->method('all')
            ->willReturn([]);

        $listAllOrdersUseCase = new ListAllOrdersUseCase($orderRepository);

        // Act
        $result = $listAllOrdersUseCase->execute([]);

        // Assert
        $this->assertEquals([], $result);
    }
}
