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
