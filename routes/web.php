<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'auth.login');
Route::view('login', 'auth.login');

Auth::routes();

/* --- Solo usuarios autenticados --- */
Route::group(['middleware' => 'auth'], function (){
  /* --- Dashboard --- */
  Route::get('dashboard', 'HomeController@dashboard')->name('dashboard');

  /* --- Perfil --- */
  Route::get('perfil', 'HomeController@perfil')->name('perfil');
  Route::patch('perfil', 'HomeController@update')->name('perfil.update');
  Route::patch('perfil/password', 'HomeController@password')->name('perfil.password');

  /* --- Insumos --- */
  Route::resource('insumos', 'InsumosControllers');
  /* --- Stock --- */
  Route::resource('stocks', 'StocksControllers')->only(['edit', 'update']);
  /* --- Insumos Tipos --- */
  Route::resource('tipos', 'InsumosTiposControllers');
  /* --- Insumos Formatos --- */
  Route::resource('formatos', 'InsumosFormatosControllers');

  /* --- Admin --- */
  Route::prefix('/admin')->name('admin.')->namespace('Admin')->middleware('role:admin')->group(function(){
    /* --- Users --- */
    Route::get('users/create/{role?}', 'UsersControllers@create')->name('users.create');
    Route::resource('users', 'UsersControllers')->except(['create']);
    Route::patch('users/{user}/password', 'UsersControllers@password')->name('users.password');

    /* --- Clientes --- */
    Route::resource('cliente', 'ClienteController');

    /* --- Vehiculo --- */
    Route::get('vehiculo/create/{cliente?}', 'VehiculosController@create')->name('vehiculo.create');
    Route::resource('vehiculo', 'VehiculosController')
          ->except(['create']);

    /* --- Vehiculo Anio --- */
    Route::resource('vehiculo/anio', 'VehiculosAnioController', ['names' => 'vehiculo.anio']);

    /* --- Vehiculo Marca --- */
    Route::post('vehiculo/marca/{marca}/modelos', 'VehiculosMarcaController@modelos');
    Route::resource('vehiculo/marca', 'VehiculosMarcaController', ['names' => 'vehiculo.marca']);

    /* --- Vehiculo Modelo --- */
    Route::resource('vehiculo/modelo', 'VehiculosModeloController', ['names' => 'vehiculo.modelo']);

    /* --- Configurations --- */
    Route::get('configurations', 'ConfigurationsControllers@edit')->name('configurations.edit');
    Route::patch('configurations', 'ConfigurationsControllers@update')->name('configurations.update');
  });
});
