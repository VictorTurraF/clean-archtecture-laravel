<?php

namespace Tests\Feature;

use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SellerControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testIndexEndpointListsAllSellers()
    {
        // Create some sellers in the database for testing
        $seller1 = Seller::factory()->create();
        $seller2 = Seller::factory()->create();
        $seller3 = Seller::factory()->create();

        // Send a GET request to the /api/sellers endpoint
        $response = $this->getJson('/api/seller');

        // Assert that the response has a status code of 200 OK
        // and contains the expected JSON structure with the sellers' data
        $response->assertStatus(200)
            ->assertJson([
                [
                    'id' => $seller1->id,
                    'name' => $seller1->name,
                    'email' => $seller1->email,
                    // Add other attributes as needed
                ],
                [
                    'id' => $seller2->id,
                    'name' => $seller2->name,
                    'email' => $seller2->email,
                    // Add other attributes as needed
                ],
                [
                    'id' => $seller3->id,
                    'name' => $seller3->name,
                    'email' => $seller3->email,
                    // Add other attributes as needed
                ],
            ]);
    }


    public function testStoreEndpointCreatesSeller()
    {
        $sellerData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];

        $response = $this->postJson('/api/seller', $sellerData);

        $response->assertStatus(201)
            ->assertJson([
                'name' => $sellerData['name'],
                'email' => $sellerData['email']
            ]);


        $sellerId = $response->json('id');

        $this->assertNotNull($sellerId);

        $createdSeller = Seller::find($sellerId);
        $this->assertEquals($sellerData['name'], $createdSeller->name);
        $this->assertEquals($sellerData['email'], $createdSeller->email);
    }

    public function testStoreEndpointNotCreateIfSellerAlreadyExists()
    {
        $sellerData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
        ];

        Seller::create($sellerData);

        // Attempt to create another seller with the same email
        $response = $this->postJson('/api/seller', $sellerData);

        // Assert that the response status is 400 Bad Request
        // and contains the expected error message
        $response->assertStatus(400)
            ->assertJson([
                'message' => 'Já existe um vendedor cadastrado com este email'
            ]);
    }
}
