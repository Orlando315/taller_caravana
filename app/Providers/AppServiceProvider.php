<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Stock;

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
      view()->composer('*', function ($view){
        $currentRoute = explode('.', Route::currentRouteName())[0];
        $lowStocks = Schema::hasTable('stocks') && Auth::check() ? Stock::whereColumn('stock', '<=', 'minimo')->get() : [];

        $view->with(compact('currentRoute', 'lowStocks'));
      });
      setlocale(LC_TIME, config('app.locale'));
    }
}
