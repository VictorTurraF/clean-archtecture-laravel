<?php

namespace App\Http\Controllers;

use Core\UseCase\ListAllOrdersBySellerUseCase;

class SellerOrderController extends Controller
{
    public function index(
        string $seller,
        ListAllOrdersBySellerUseCase $useCase
    ) {
        $result = $useCase->execute($seller);

        return response()->json($result, 200);
    }
}
