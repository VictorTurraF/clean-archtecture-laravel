<?php

namespace Core\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Core\Entity\Seller;
use Core\Exceptions\SellerEmailIsInvalidError;
use Core\Exceptions\SellerNameIsInvalidError;

class SellerEntityTest extends TestCase {
    /**
     * A basic test example.
     */
    public function test_should_create(): void
    {
        $seller = new Seller([
            "name" => "Test Seller",
            "email" => "test@example.com",
        ]);

        $this->assertInstanceOf(Seller::class, $seller);
    }

    public function test_should_name_be_required(): void
    {
        $this->expectException(SellerNameIsInvalidError::class);

        new Seller([
            "email" => "test@example.com",
        ]);
    }

    public function test_should_name_has_bigger_then_3(): void
    {
        $this->expectException(SellerNameIsInvalidError::class);

        new Seller([
            "email" => "test@example.com",
            "name" => "Oi"
        ]);
    }

    public function test_should_email_be_required(): void
    {
        $this->expectException(SellerEmailIsInvalidError::class);

        new Seller([
            "name" => "Test name",
        ]);
    }

    public function test_should_email_be_valid(): void
    {
        $this->expectException(SellerEmailIsInvalidError::class);

        new Seller([
            "name" => "Test name",
            "email" => "invalid"
        ]);
    }

    public function test_should_convert_to_array(): void
    {
        $seller = new Seller([
            "name" => "Test name",
            "email" => "test@example.com"
        ], "1");

        $toArraySeller = $seller->toArray();

        $this->assertEquals([
            'id' => 1,
            'name' => "Test name",
            'email' => "test@example.com"
        ], $toArraySeller);
    }
}
