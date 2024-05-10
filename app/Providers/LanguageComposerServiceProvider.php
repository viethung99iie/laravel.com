<?php

namespace App\Providers;

use App\Repositories\Interfaces\LanguageRepositoryInterface as LanguageRepository;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LanguageComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Interfaces\LanguageRepositoryInterface', 'App\Repositories\LanguageRepository');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'backend.dashboard.component.nav', function ($view) {
                $languageRepository = $this->app->make(LanguageRepository::Class);
                $language = $languageRepository->all();
                $view->with('language', $language);
            },
        );

    }
}
