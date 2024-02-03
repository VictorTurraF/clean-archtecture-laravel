<?php

namespace Tests\Feature;

use App\External\Repository\EloquentOrderRepository;
use App\Models\Order;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SellerOrderControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testListAllOrdersOfAnSpecificSeller()
    {
        // Arrange
        $seller = Seller::factory()->create();
        $ordersOfSeller = Order::factory()->count(2)->create([ 'seller_id' => $seller->id ]);
        $otherOrders = Order::factory()->count(4)->create();

        $expectedOrders = $this->parseEloquentOrderModelToExpectedResponse($ordersOfSeller);
        $notExpetedOrders = $this->parseEloquentOrderModelToExpectedResponse($otherOrders);

        // Act
        $response = $this->getJson("/api/sellers/{$seller->id}/orders");

        // Assert
        $response
            ->assertOk()
            ->assertJson($expectedOrders)
            ->assertJsonMissing($notExpetedOrders)
            ->assertJsonCount(2);
    }

    private function parseEloquentOrderModelToExpectedResponse(Collection $orders)
    {
        return $orders
            ->map(fn ($order) => EloquentOrderRepository::mapOrderToCoreOrder($order))
            ->map(fn ($coreOrder) => $coreOrder->toArray())
            ->toArray();
    }
}
