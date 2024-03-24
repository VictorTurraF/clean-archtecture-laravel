<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSellerRequest;
use Core\UseCase\CreateSellerUseCase;
use Core\UseCase\ListAllSellersUseCase;

use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;
use App\OpenApi\RequestBodies\CreateSellerRequestBody;
use App\OpenApi\Responses\ListSellersResponse;
use App\OpenApi\Responses\SingleSellerResponse;

#[OpenApi\PathItem]
class SellerController extends Controller
{
    /**
     * Sellers
     *
     * List all sellers
     */
    #[OpenApi\Operation(tags: ['seller'], method: 'GET')]
    #[OpenApi\Response(factory: ListSellersResponse::class, statusCode: 200)]
    public function index(
        ListAllSellersUseCase $useCase,
    ) {
        $result = $useCase->execute();

        return response()->json($result, 200);
    }

    /**
     * Create sellers
     *
     * Creates a new seller
     */
    #[OpenApi\Operation(tags: ['seller'], method: 'POST')]
    #[OpenApi\RequestBody(factory: CreateSellerRequestBody::class)]
    #[OpenApi\Response(factory: SingleSellerResponse::class)]
    public function store(
        CreateSellerRequest $request,
        CreateSellerUseCase $useCase
    ) {
        $validated = $request->validated();

        $result = $useCase->execute($validated);

        return response()->json($result, 201);
    }
}
