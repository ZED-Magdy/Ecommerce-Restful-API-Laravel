<?php

namespace App\Providers;

use App\Http\Repositories\Interfaces\ApiAuthInterface;
use App\Http\Repositories\Interfaces\ProductsRepositoryInterface;
use App\Http\Repositories\JWTAuthRepository;
use App\Http\Repositories\ProductsRepository;
use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ApiAuthInterface::class, JWTAuthRepository::class);
        $this->app->bind(ProductsRepositoryInterface::class, ProductsRepository::class);
    }
}
