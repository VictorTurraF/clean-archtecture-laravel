<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\OrderSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;

class ListOrdersResponse extends ResponseFactory
{
    public function build(): Response
    {
        $response = Schema::array()->items(OrderSchema::ref());

        return Response::create('Success')
            ->description('Success response containing list of sellers')
            ->content(
                MediaType::json()->schema($response)
            );
    }
}
