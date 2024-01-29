<?php

namespace App\Providers;

use App\External\Repository\EloquentOrderRepository;
use App\External\Repository\EloquentSellerRepository;
use Core\Contracts\Repository\OrderRepository;
use Core\Contracts\Repository\SellerRepository;
use Illuminate\Support\ServiceProvider;

class CoreDependenciesServiceProvider extends ServiceProvider
{
    public $bindings = [
        SellerRepository::class => EloquentSellerRepository::class,
        OrderRepository::class => EloquentOrderRepository::class
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
