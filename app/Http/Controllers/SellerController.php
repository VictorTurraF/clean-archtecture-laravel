<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSellerRequest;
use Core\UseCase\CreateSellerUseCase;
use Core\UseCase\ListAllSellersUseCase;

class SellerController extends Controller
{
    public function index(
        ListAllSellersUseCase $useCase,
    ) {
        $result = $useCase->execute();

        return response()->json($result, 200);
    }

    public function store(
        CreateSellerRequest $request,
        CreateSellerUseCase $useCase
    ) {
        $validated = $request->validated();

        $result = $useCase->execute($validated);

        return response()->json($result, 201);
    }
}
