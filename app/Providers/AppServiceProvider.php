<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use View;
use Cache;
use Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        $settings=Cache::rememberForever('settings', function () {
            return Setting::first();
        });
        View::share('settings', $settings);


        $categories=Cache::rememberForever('categories.all', function () {
            return Category::all();
        });

        View::share('categories', $categories);
    }
}
