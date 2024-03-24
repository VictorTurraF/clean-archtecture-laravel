<?php

namespace App\Http\Controllers;

use Core\UseCase\ListAllOrdersBySellerUseCase;

use App\OpenApi\Responses\ListOrdersResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class SellerOrderController extends Controller
{
    /**
     * Seller's Orders
     *
     * List all orders from an specified seller with seller_id
     *
     * @param string $seller Seller ID
     */
    #[OpenApi\Operation(tags: ['order'], method: 'GET')]
    #[OpenApi\Response(factory: ListOrdersResponse::class, statusCode: 200)]
    public function index(
        string $seller,
        ListAllOrdersBySellerUseCase $useCase
    ) {
        $result = $useCase->execute($seller);

        return response()->json($result, 200);
    }
}
