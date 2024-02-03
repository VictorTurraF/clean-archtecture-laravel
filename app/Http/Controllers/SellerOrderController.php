<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    public function index()
    {
        return response()->json([], 501);
    }
}
