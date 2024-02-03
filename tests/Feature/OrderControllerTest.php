<?php

namespace Tests\Feature;

use App\External\Repository\EloquentOrderRepository;
use App\Models\Order;
use Core\Entity\Order as CoreOrder;
use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateOrderEndpoint()
    {
        // Assuming you have a seller in the database
        $seller = Seller::factory()->create();

        $orderData = [
            'seller_id' => $seller->id,
            'price_in_cents' => 1000,
            'payment_approved_at' => '2023-01-01T12:00',
            // Add other attributes as needed
        ];

        // Send a POST request to the /api/order endpoint
        $response = $this->postJson('/api/order', $orderData);

        // Assert that the response has a status code of 201 Created
        // and contains the expected JSON structure
        $response
            ->assertStatus(201)
            ->assertJson(
                fn (AssertableJson $json) =>
                    $json->has('id')
                        ->where('seller_id', $seller->id)
                        ->where('price', [
                            'in_cents' => 1000,
                            'formatted' => "R$ 10,00"
                        ])
                        ->where('payment_approved_at', [
                            'iso_date' => '2023-01-01T12:00',
                            'formatted' => '01/01/2023 12:00',
                        ])
            );

        // Assert the order exists in the database
        $foundOrder = Order::find($response->json('id'));

        $this->assertNotNull($foundOrder);
        $this->assertEquals($response->json('id'), $foundOrder->id);
        $this->assertEquals($response->json('price.in_cents'), $foundOrder->price_in_cents);
        $this->assertEquals($response->json('payment_approved_at.iso_date'), $foundOrder->payment_approved_at->format('Y-m-d\TH:i'));
    }

    public function testListAllOrdersEndpoint()
    {
        // Arrange
        $orders = Order::factory()->count(3)->create();
        $transformedOrders = $orders
            ->map(fn ($order) => EloquentOrderRepository::mapOrderToCoreOrder($order)->toArray())
            ->toArray();

        // Act
        $response = $this->getJson('/api/order');

        // Assert
        $response
            ->assertOk()
            ->assertJson(
                fn (AssertableJson $json) =>
                    $json->has(3)
            )
            ->assertJson(
                $transformedOrders
            );
    }
}
