<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\Schemas\CreateOrderSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class CreateOrderRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('CreateOrder')
            ->description('Order data')
            ->content(
                MediaType::json()->schema(CreateOrderSchema::ref())
            );
    }
}
