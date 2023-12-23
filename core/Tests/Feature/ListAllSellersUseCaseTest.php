<?php

namespace Core\Tests\Feature;

use Core\Contracts\Repository\SellerRepository;
use Core\Entity\Seller;
use Core\UseCase\ListAllSellersUseCase;
use PHPUnit\Framework\TestCase;

class ListAllSellersUseCaseTest extends TestCase
{
    public function testExecuteReturnsArrayOfSellers()
    {
        $seller1 = new Seller(['name' => 'John Doe', 'email' => 'john@example.com']);
        $seller2 = new Seller(['name' => 'Jane Doe', 'email' => 'jane@example.com']);

        $sellerRepositoryStub = $this->createMock(SellerRepository::class);
        $sellerRepositoryStub
            ->method('all')
            ->willReturn([$seller1, $seller2]);

        $listAllSellersUseCase = new ListAllSellersUseCase($sellerRepositoryStub);

        $result = $listAllSellersUseCase->execute([]);

        $expectedResult = [
            $seller1->toArray(),
            $seller2->toArray(),
        ];

        $this->assertEquals($expectedResult, $result);
    }

    public function testExecuteReturnsEmptyArrayWhenNoSellers()
    {
        $sellerRepositoryStub = $this->createMock(SellerRepository::class);
        $sellerRepositoryStub
            ->method('all')
            ->willReturn([]);

        $listAllSellersUseCase = new ListAllSellersUseCase($sellerRepositoryStub);

        $result = $listAllSellersUseCase->execute([]);

        $this->assertEquals([], $result);
    }
}
