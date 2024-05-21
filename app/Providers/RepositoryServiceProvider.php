<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    public $bindings = [
        'App\Repositories\Interfaces\UserRepositoryInterface' => 'App\Repositories\UserRepository',
        'App\Repositories\Interfaces\UserCatalogueRepositoryInterface' => 'App\Repositories\UserCatalogueRepository',
        'App\Repositories\Interfaces\LanguageRepositoryInterface' => 'App\Repositories\LanguageRepository',
        'App\Repositories\Interfaces\PostCatalogueRepositoryInterface' => 'App\Repositories\PostCatalogueRepository',
        'App\Repositories\Interfaces\GenerateRepositoryInterface' => 'App\Repositories\GenerateRepository',
        'App\Repositories\Interfaces\PermissionRepositoryInterface' => 'App\Repositories\PermissionRepository',
        'App\Repositories\Interfaces\PostRepositoryInterface' => 'App\Repositories\PostRepository',
        'App\Repositories\Interfaces\ProvinceRepositoryInterface' => 'App\Repositories\ProvinceRepository',
        'App\Repositories\Interfaces\DistrictRepositoryInterface' => 'App\Repositories\DistrictRepository',
        'App\Repositories\Interfaces\RouterRepositoryInterface' => 'App\Repositories\RouterRepository',
        // 'App\Repositories\Interfaces\ProductCatalogueRepositoryInterface' => 'App\Repositories\ProductCatalogueRepository',
        // 'App\Repositories\Interfaces\ProductRepositoryInterface' => 'App\Repositories\ProductRepository',
        // 'App\Repositories\Interfaces\ProductCatalogueRepositoryInterface' => 'App\Repositories\ProductCatalogueRepository',
        // 'App\Repositories\Interfaces\ProductRepositoryInterface' => 'App\Repositories\ProductRepository',
        // 'App\Repositories\Interfaces\AttributeCatalogueRepositoryInterface' => 'App\Repositories\AttributeCatalogueRepository',
        // 'App\Repositories\Interfaces\AttributeRepositoryInterface' => 'App\Repositories\AttributeRepository',
        'App\Repositories\Interfaces\ProductCatalogueRepositoryInterface' => 'App\Repositories\ProductCatalogueRepository',

        'App\Repositories\Interfaces\ProductRepositoryInterface' => 'App\Repositories\ProductRepository',
        'App\Repositories\Interfaces\ProductRepositoryInterface' => 'App\Repositories\ProductRepository',
    ];

    public function register(): void
    {
        foreach ($this->bindings as $key => $val) {
            $this->app->bind($key, $val);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
