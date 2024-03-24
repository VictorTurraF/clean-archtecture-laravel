<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\SellerSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;

class ListSellersResponse extends ResponseFactory implements Reusable
{
    public function build(): Response
    {
        $response = Schema::array()->items(SellerSchema::ref());

        return Response::create('Success')
            ->description('Success response containing list of sellers')
            ->content(
                MediaType::json()->schema($response)
            );
    }
}
