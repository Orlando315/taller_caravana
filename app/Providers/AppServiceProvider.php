<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\{View, Route, Auth};
use App\Insumo;

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
        $insumosWithStockMinimo = Auth::check() ?
                                                Insumo::whereNotNull('minimo')
                                                      ->selectRaw('insumos.*, SUM(stocks.stock) as total')
                                                      ->join('stocks', 'insumos.id', '=', 'stocks.insumo_id')
                                                      ->groupBy('insumos.id')
                                                      ->havingRaw('minimo >= total')
                                                      ->get()
                                                : [];

        $view->with(compact('currentRoute', 'insumosWithStockMinimo'));
      });

      setlocale(LC_ALL, 'es_ES', 'Spanish_Spain', 'Spanish');
    }
}
