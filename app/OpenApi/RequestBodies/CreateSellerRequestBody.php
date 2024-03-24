<?php

namespace App\OpenApi\RequestBodies;

use App\OpenApi\Schemas\CreateSellerSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

class CreateSellerRequestBody extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create('CreateSeller')
            ->description('Seller data')
            ->content(
                MediaType::json()->schema(CreateSellerSchema::ref())
            );
    }
}
