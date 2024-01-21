<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSellerRequest;
use Core\UseCase\CreateSellerUseCase;

class SellerController extends Controller
{

    public function index()
    {
        //
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
