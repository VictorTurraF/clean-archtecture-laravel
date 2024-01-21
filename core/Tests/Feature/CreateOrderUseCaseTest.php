<?php

use Core\Contracts\Repository\OrderRepository;
use Core\Contracts\Repository\SellerRepository;
use Core\Entity\Order;
use Core\Exceptions\SellerNotFoundError;
use Core\UseCase\CreateOrderUseCase;
use PHPUnit\Framework\TestCase;

class CreateOrderUseCaseTest extends TestCase
{
    public function testExecuteCreatesOrderWhenSellerExists()
    {
        $sellerRepositoryStub = $this->createMock(SellerRepository::class);
        $sellerRepositoryStub
            ->method('existsById')
            ->willReturn(false);

        $order = new Order([
            'seller_id' => '1234567',
            'price_in_cents' => 1000,
            'payment_approved_at' => '2023-01-01T12:00',
        ]);

        $orderRepositoryMock = $this->createMock(OrderRepository::class);
        $orderRepositoryMock
            ->expects($this->once())
            ->method('create')
            ->with($order)
            ->willReturn($order);

        $createOrderUseCase = new CreateOrderUseCase($sellerRepositoryStub, $orderRepositoryMock);

        $result = $createOrderUseCase->execute([
            'seller_id' => '1234567',
            'price_in_cents' => 1000,
            'payment_approved_at' => '2023-01-01T12:00',
        ]);

        $this->assertEquals($order->toArray(), $result);
    }

    public function testExecuteThrowsExceptionWhenSellerNotFound()
    {
        $sellerRepositoryStub = $this->createMock(SellerRepository::class);
        $sellerRepositoryStub
            ->method('existsById')
            ->willReturn(true);

        $orderRepositoryMock = $this->createMock(OrderRepository::class);

        $createOrderUseCase = new CreateOrderUseCase($sellerRepositoryStub, $orderRepositoryMock);

        $this->expectException(SellerNotFoundError::class);

        $createOrderUseCase->execute([
            'seller_id' => 'seller123',
            'price_in_cents' => 1000,
            'payment_approved_at' => '2023-01-01T12:00',
        ]);
    }
}
