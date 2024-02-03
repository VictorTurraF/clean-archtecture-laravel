<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use Core\UseCase\CreateOrderUseCase;
use Core\UseCase\ListAllOrdersUseCase;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(
        ListAllOrdersUseCase $useCase
    ) {
        $result = $useCase->execute();

        return response()->json($result, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        CreateOrderRequest $request,
        CreateOrderUseCase $useCase
    ) {
        $validated = $request->validated();

        $result = $useCase->execute($validated);

        return response()->json($result, 201);
    }
}
