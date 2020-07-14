<?php

namespace App\Providers;

use App\Http\Repositories\CategoryRepository;
use App\Http\Repositories\Interfaces\ApiAuthInterface;
use App\Http\Repositories\Interfaces\ProductsRepositoryInterface;
use App\Http\Repositories\JWTAuthRepository;
use App\Http\Repositories\ProductsRepository;
use App\Models\Category;
use App\Models\Product;
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
        $this->app->bind('ProductRepository', function () {
            return new ProductsRepository(new Product());
        });
        $this->app->bind('CategoryRepository', function () {
            return new CategoryRepository(new Category());
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ApiAuthInterface::class, JWTAuthRepository::class);
        // $this->app->bind(ProductsRepositoryInterface::class, ProductsRepository::class);
    }
}
