<?php

namespace App\OpenApi\Schemas;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AllOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\AnyOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Not;
use GoldSpecDigital\ObjectOrientedOAS\Objects\OneOf;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class OrderSchema extends SchemaFactory implements Reusable
{
    /**
     * @return AllOf|OneOf|AnyOf|Not|Schema
     */
    public function build(): SchemaContract
    {
        return Schema::object('Order')
            ->properties(
                Schema::string('id')->default("9ba28008-8af5-41fe-924e-30be527a2928"),
                Schema::string('seller_id')->default("9ba25f3c-a127-41ab-ba29-6d94b97c1c51"),
                Schema::object("price")->properties(
                    Schema::number("in_cents")->default(10000),
                    Schema::string("formatted")->default("R$ 100,00"),
                ),
                Schema::object("payment_approved_at")->properties(
                    Schema::string("iso_date")->default("2024-03-22T23:00"),
                    Schema::string("formatted")->default("22/03/2024 23:00"),
                )
            );
    }
}
