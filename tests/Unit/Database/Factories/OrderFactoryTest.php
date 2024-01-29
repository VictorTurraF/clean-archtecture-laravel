<?php

namespace Tests\Unit\Database\Factories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Order;

class OrderFactoryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Test creating an order using the OrderFactory.
     *
     * @return void
     */
    public function testCreateOrder()
    {
        $order = Order::factory()->create();

        // Assert that the order was created successfully
        $this->assertDatabaseCount('orders', 1);
        $this->assertInstanceOf(Order::class, $order);
        $this->assertNotNull($order->seller_id);
        $this->assertNotNull($order->price_in_cents);
        // Add more assertions as needed for your specific case
    }
}
