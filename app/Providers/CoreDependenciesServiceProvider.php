<?php

namespace App\Providers;

use App\External\Repository\EloquentSellerRepository;
use Core\Contracts\Repository\SellerRepository;
use Illuminate\Support\ServiceProvider;

class CoreDependenciesServiceProvider extends ServiceProvider
{
    public $bindings = [
        SellerRepository::class => EloquentSellerRepository::class,
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
