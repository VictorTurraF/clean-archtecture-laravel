<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\External\Repository\EloquentSellerRepository;
use Core\Entity\Seller as CoreSeller;
use PHPUnit\Framework\Attributes\Depends;

class EloquentSellerRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private EloquentSellerRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new EloquentSellerRepository();
    }

    public function testCreateSeller()
    {
        $sellerData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            // Add other attributes as needed
        ];

        $seller = new CoreSeller($sellerData);

        $createdSeller = $this->repository->create($seller);

        $this->assertInstanceOf(CoreSeller::class, $createdSeller);
        $this->assertNotNull($createdSeller->getId());
        $this->assertEquals($sellerData['name'], (string) $createdSeller->props()->name);
        $this->assertEquals($sellerData['email'], (string) $createdSeller->props()->email);
        // Add assertions for other attributes
    }

    #[Depends('testCreateSeller')]
    public function testExistsByEmail()
    {
        $sellerEmail = 'john@example.com';

        // Assuming the email does not exist initially
        $this->assertFalse($this->repository->existsByEmail($sellerEmail));

        // Create a seller with the given email
        $seller = new CoreSeller(['name' => 'John Doe', 'email' => $sellerEmail]);
        $this->repository->create($seller);

        // Now the email should exist
        $this->assertTrue($this->repository->existsByEmail($sellerEmail));
    }

    #[Depends('testCreateSeller')]
    public function testAllSellers()
    {
        // Create multiple sellers
        $sellerData1 = ['name' => 'John Doe', 'email' => 'john@example.com'];
        $sellerData2 = ['name' => 'Jane Doe', 'email' => 'jane@example.com'];

        $seller1 = $this->repository->create(new CoreSeller($sellerData1));
        $seller2 = $this->repository->create(new CoreSeller($sellerData2));

        // Retrieve all sellers from the repository
        $allSellers = $this->repository->all();

        // Ensure that the retrieved sellers match the created sellers
        $this->assertCount(2, $allSellers);
        $this->assertEquals($seller1->toArray(), $allSellers[0]->toArray());
        $this->assertEquals($seller2->toArray(), $allSellers[1]->toArray());
    }

    #[Depends('testCreateSeller')]
    public function testExistsById()
    {
        // Create a new seller
        $sellerData = ['name' => 'John Doe', 'email' => 'john@example.com'];
        $seller =$this->repository->create(new CoreSeller($sellerData));

        // Check if the seller exists by ID
        $this->assertTrue($this->repository->existsById($seller->getId()));

        // Check with a non-existent ID
        $this->assertFalse($this->repository->existsById('nonexistent_id'));
    }

    #[Depends('testCreateSeller')]
    public function testShouldFindSellerById()
    {
        // Arrange
        $sellerData = ['name' => 'John Doe', 'email' => 'john@example.com'];
        $seller = $this->repository->create(new CoreSeller($sellerData));

        // Act
        $result = $this->repository->findById($seller->getId());

        // Assert
        $this->assertEquals($seller->getId(), $result->getId());
    }
}
