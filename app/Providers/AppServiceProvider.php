<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share categories with all views
        view()->composer('*', function ($view) {
            $categories = \App\Models\Category::where('is_active', true)
                ->whereNull('parent_id')
                ->withCount('products')
                ->get();
            $view->with('categories', $categories);
        });
    }
}
