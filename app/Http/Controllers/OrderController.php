<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use Core\UseCase\CreateOrderUseCase;
use Core\UseCase\ListAllOrdersUseCase;

use App\OpenApi\RequestBodies\CreateOrderRequestBody;
use App\OpenApi\Responses\ListOrdersResponse;
use App\OpenApi\Responses\SingleOrderResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class OrderController extends Controller
{
    /**
     * Orders
     *
     * Display a listing of all orders
     */
    #[OpenApi\Operation(tags: ['order'], method: 'GET')]
    #[OpenApi\Response(factory: ListOrdersResponse::class, statusCode: 200)]
    public function index(
        ListAllOrdersUseCase $useCase
    ) {
        $result = $useCase->execute();

        return response()->json($result, 200);
    }

    /**
     * Create an order
     *
     * Store a newly created order in storage.
     */
    #[OpenApi\Operation(tags: ['order'], method: 'POST')]
    #[OpenApi\RequestBody(factory: CreateOrderRequestBody::class)]
    #[OpenApi\Response(factory: SingleOrderResponse::class)]
    public function store(
        CreateOrderRequest $request,
        CreateOrderUseCase $useCase
    ) {
        $validated = $request->validated();

        $result = $useCase->execute($validated);

        return response()->json($result, 201);
    }
}
