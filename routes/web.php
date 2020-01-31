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
    Route::post('cliente/{cliente}/vehiculos', 'ClienteController@vehiculos');
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

    /* --- Proveedores vehiculos --- */
    Route::resource('proveedor', 'ProveedorController');

    /* --- Proveedores vehiculos --- */
    Route::get('proveedor/vehiculo/create/{proveedor}','ProveedorVehiculoController@create')->name('proveedor.vehiculo.create');
    Route::post('proveedor/vehiculo/create/{proveedor}','ProveedorVehiculoController@store')->name('proveedor.vehiculo.store');
    Route::resource('proveedor/vehiculo', 'ProveedorVehiculoController', ['names' => 'proveedor.vehiculo'])
          ->only(['destroy']);
    Route::post('proveedor/vehiculo/modelos','ProveedorVehiculoController@search_modelo')->name('proveedor.vehiculo.search.modelo');

    /* --- Agendamientos --- */
    Route::get('agendamiento/create/{proceso}', 'AgendamientoController@create')->name('agendamiento.create');
    Route::post('agendamiento/create/{proceso}', 'AgendamientoController@store')->name('agendamiento.store');
    Route::resource('agendamiento', 'AgendamientoController')
          ->except(['create', 'store', 'show']);

    /* --- Procesos --- */
    Route::resource('proceso', 'ProcesoController');

    /* --- Configurations --- */
    Route::get('configurations', 'ConfigurationsControllers@edit')->name('configurations.edit');
    Route::patch('configurations', 'ConfigurationsControllers@update')->name('configurations.update');
  });
});
