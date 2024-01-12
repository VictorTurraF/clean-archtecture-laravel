<?php

namespace Core\Tests\Feature;

use Core\Contracts\Repository\SellerRepository;
use Core\Entity\Seller;
use Core\Exceptions\SellerAlreadyExistsError;
use Core\UseCase\CreateSellerUseCase;
use PHPUnit\Framework\TestCase;

class CreateSellerUseCaseTest extends TestCase
{
    public function test_execute_throws_exception_when_seller_exists()
    {
        $sellerRepositoryMock = $this->createMock(SellerRepository::class);
        $sellerRepositoryMock
            ->expects($this->once())
            ->method('existsByEmail')
            ->willReturn(true);

        $createSellerUseCase = new CreateSellerUseCase($sellerRepositoryMock);

        $this->expectException(SellerAlreadyExistsError::class);

        $createSellerUseCase->execute([
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);
    }

    public function test_execute_creates_seller_when_not_exists()
    {
        $sellerRepositoryStub = $this->createMock(SellerRepository::class);
        $sellerRepositoryStub
            ->method('existsByEmail')
            ->willReturn(false);

        $createdSeller = new Seller([
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);

        $sellerRepositoryStub
            ->expects($this->once())
            ->method('create')
            ->willReturn($createdSeller);

        $createSellerUseCase = new CreateSellerUseCase($sellerRepositoryStub);

        $result = $createSellerUseCase->execute([
            'name' => 'John Doe',
            'email' => 'john@example.com'
        ]);

        $this->assertEquals($createdSeller->toArray(), $result);
    }
}
