<?php

namespace Tests\Unit;

use App\External\Repository\EloquentOrderRepository;
use App\Models\Order;
use App\Models\Seller;
use Core\Entity\Order as CoreOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class EloquentOrderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private EloquentOrderRepository $orderRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Assuming you have a concrete implementation of OrderRepository.
        $this->orderRepository = new EloquentOrderRepository();
    }

    public function testAllOrdersAreReturned()
    {
        Order::factory()->count(3)->create();

        $orders = $this->orderRepository->all();

        $this->assertIsArray($orders);
        $this->assertContainsOnlyInstancesOf(CoreOrder::class, $orders);
        $this->assertCount(3, $orders);
    }

    public function testOrderExistsById()
    {
        // Replace $orderId with an actual order ID from your data.
        $order = Order::factory()->create();

        $exists = $this->orderRepository->existsById($order->id);

        $this->assertTrue($exists);
    }

    public function testOrderNotExistsById()
    {
        $exists = $this->orderRepository->existsById("any-id");

        $this->assertFalse($exists);
    }

    public function testCreateOrder()
    {
        $seller = Seller::factory()->create();

        // Replace $input with valid data for creating an order.
        $orderToBeCreated = new CoreOrder([
            'seller_id' => $seller->id,
            'price_in_cents' => 10000,
            'payment_approved_at' => '2024-01-10T20:45'
        ]);

        $createdOrder = $this->orderRepository->create($orderToBeCreated);
        $result = $createdOrder->toArray();

        $this->assertInstanceOf(CoreOrder::class, $createdOrder);
        $this->assertArrayHasKey('id', $result);
        $this->assertEquals($orderToBeCreated->toArray(), $createdOrder->toArray());
    }

    public function testFindBySellerId()
    {
        // Replace $sellerId with an actual seller ID from your data.
        $sellerId = 1;

        $orders = $this->orderRepository->findBySellerId($sellerId);

        $this->assertIsArray($orders);
        $this->assertContainsOnlyInstancesOf(Order::class, $orders);
    }

    public function testFindByFiltersWithSellerId()
    {
        // Arrange
        $seller = Seller::factory()->create();

        $orders = Order::factory()->count(2)->create([
            'seller_id' => $seller->id,
        ]);

        Order::factory()->count(3)->create();

        // Execute
        $foundOrders = $this->orderRepository->findByFilters([
            'seller_id' => $seller->id,
        ]);

        // Assert
        $this->assertCount(2, $foundOrders);
        $this->assertContainsOnlyInstancesOf(CoreOrder::class, $foundOrders);
    }
}
