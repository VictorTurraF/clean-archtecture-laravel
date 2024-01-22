<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        // Send a POST request to the /api/orders endpoint
        $response = $this->postJson('/api/orders', $orderData);

        // Assert that the response has a status code of 201 Created
        // and contains the expected JSON structure
        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $response->json('data.id'), // Optionally, assert the order ID
                    'seller_id' => $seller->id,
                    'price_in_cents' => $orderData['price_in_cents'],
                    'payment_approved_at' => $orderData['payment_approved_at'],
                    // Add other attributes as needed
                ],
            ]);

        // Optionally, assert the order exists in the database
        $createdOrder = Order::find($response->json('data.id'));
        $this->assertNotNull($createdOrder);
        $this->assertEquals($orderData['price_in_cents'], $createdOrder->getProps()->getPriceInCents());
        // Add other assertions for the order entity

        // Optionally, assert the seller's orders relationship is updated
        $this->assertTrue($seller->orders->contains($createdOrder));
    }

}
