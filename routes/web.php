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

  /* --- Vehiculo --- */
  Route::resource('vehiculo', 'VehiculoController');

  /* --- Procesos --- */
  Route::resource('proceso', 'ProcesoController')
        ->only(['index', 'show']);

  /* --- Cotizacion --- */
  Route::get('cotizacion/create/{situacion}', 'CotizacionController@create')->name('cotizacion.create');
  Route::post('cotizacion/{situacion}', 'CotizacionController@store')->name('cotizacion.store');
  Route::resource('cotizacion', 'CotizacionController')
        ->only(['show']);

  /* --- Admin --- */
  Route::prefix('/admin')->name('admin.')->namespace('Admin')->middleware('role:staff')->group(function(){
    /* --- Users --- */
    Route::resource('users', 'UsersControllers');
    Route::patch('users/{user}/password', 'UsersControllers@password')->name('users.password');

    /* --- Insumos --- */
    Route::resource('insumos', 'InsumosControllers');
    /* --- Stock --- */
    Route::get('insumos/stock/create/{insumo}', 'StocksControllers@create')->name('insumos.stock.create');
    Route::post('insumos/stock/{insumo}', 'StocksControllers@store')->name('insumos.stock.store');
    Route::resource('insumos/stock', 'StocksControllers')
          ->names('insumos.stock')
          ->except(['create', 'store']);
    /* --- Insumos Tipos --- */
    Route::resource('tipos', 'InsumosTiposControllers');
    /* --- Insumos Formatos --- */
    Route::resource('formatos', 'InsumosFormatosControllers');

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

    /* --- Repuestos --- */
    Route::resource('repuesto', 'RepuestoController');

    /* --- Procesos --- */
    Route::put('proceso/{proceso}/status', 'ProcesoController@status')->name('proceso.status');
    Route::resource('proceso', 'ProcesoController');
    
    /* --- Agendamientos --- */
    Route::get('agendamiento/create/{proceso}', 'AgendamientoController@create')->name('agendamiento.create');
    Route::post('agendamiento/create/{proceso}', 'AgendamientoController@store')->name('agendamiento.store');
    Route::resource('agendamiento', 'AgendamientoController')
          ->except(['create', 'store', 'show']);

    /* --- Preevaluaciones --- */
    Route::get('preevaluacion/create/{proceso}', 'PreevaluacionController@create')->name('preevaluacion.create');
    Route::post('preevaluacion/{proceso}', 'PreevaluacionController@store')->name('preevaluacion.store');
    Route::get('preevaluacion/{proceso}/edit', 'PreevaluacionController@edit')->name('preevaluacion.edit');
    Route::put('preevaluacion/{proceso}', 'PreevaluacionController@update')->name('preevaluacion.update');
    Route::resource('preevaluacion', 'PreevaluacionController')
          ->only(['index', 'destroy']);

    /* --- Preevaluaciones Fotos --- */
    Route::get('preevaluacion/foto', 'PreevaluacionFotoController@index')->name('preevaluacion.foto.index');
    Route::delete('preevaluacion/foto/{foto}', 'PreevaluacionFotoController@destroy')->name('preevaluacion.foto.destroy');

    /* --- Situaciones --- */
    Route::get('situacion/create/{proceso}', 'SituacionController@create')->name('situacion.create');
    Route::post('situacion/{proceso}', 'SituacionController@store')->name('situacion.store');
    Route::resource('situacion', 'SituacionController')
          ->only(['edit', 'update']);

    /* --- Situaciones Items --- */
    Route::get('situacion/item/', 'SituacionItemController@index')->name('situacion.item.index');
    Route::delete('situacion/item/{item}', 'SituacionItemController@destroy')->name('situacion.item.destroy');

    /* --- Cotizacion --- */
    Route::get('cotizacion/create/{situacion}', 'CotizacionController@create')->name('cotizacion.create');
    Route::post('cotizacion/{situacion}', 'CotizacionController@store')->name('cotizacion.store');
    Route::resource('cotizacion', 'CotizacionController')
          ->only(['show', 'destroy']);

    /* --- Pagos --- */
    Route::get('pago/create/{cotizacion}', 'PagoController@create')->name('pago.create');
    Route::post('pago/{cotizacion}', 'PagoController@store')->name('pago.store');
    Route::resource('pago', 'PagoController')
          ->only(['index', 'destroy']);

    /* --- Inspeccion --- */
    Route::get('inspeccion/create/{proceso}', 'InspeccionController@create')->name('inspeccion.create');
    Route::post('inspeccion/{proceso}', 'InspeccionController@store')->name('inspeccion.store');
    Route::resource('inspeccion', 'InspeccionController')
          ->only(['edit', 'update', 'destroy']);
    Route::get('inspeccion/foto', 'InspeccionFotoController@index')->name('inspeccion.foto.index');
    Route::delete('inspeccion/foto/{foto}', 'InspeccionFotoController@destroy')->name('inspeccion.foto.destroy');

    /* --- Configurations --- */
    Route::get('configurations', 'ConfigurationsControllers@edit')->name('configurations.edit');
    Route::patch('configurations', 'ConfigurationsControllers@update')->name('configurations.update');
  });
});
