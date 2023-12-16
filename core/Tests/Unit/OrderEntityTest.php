<?php

namespace Core\Tests\Unit;

use Core\Entity\Order;
use Core\Exceptions\OrderPriceIsInvalidError;
use PHPUnit\Framework\TestCase;

class OrderEntityTest extends TestCase
{
    public function test_to_array()
    {
        // Arrange
        $props = [
            'seller_id' => 'seller123',
            'price_in_cents' => 1000,
            'payment_approved_at' => '2023-01-01T12:00'
        ];

        $order = new Order($props, 'order123');

        // Act
        $result = $order->toArray();

        // Assert
        $expectedResult = [
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
        ];

        $this->assertEquals($expectedResult, $result);
    }

    public function test_invalid_order_props_throws_exception()
    {
        // Arrange
        $this->expectException(OrderPriceIsInvalidError::class);

        // Act
        new Order([
            'seller_id' => 'seller123',
            'price_in_cents' => 'invalid_price',
            'payment_approved_at' => '2023-01-01T12:12'
        ], 'order123');
    }
}
