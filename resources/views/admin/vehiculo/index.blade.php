@extends('layouts.app')

@section('title', 'Vehículos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.vehiculo.index') }}"> Vehículos </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">
            <i class="fa fa-car"></i> Vehículos
          </h4>
        </div>
        <div class="card-body">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="tab1-tab" href="#tab1" role="tab" data-toggle="tab" aria-controls="tab1" aria-selected="true">Vehículos ({{ $vehiculos->count() }})</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab2-tab" href="#tab2" role="tab" data-toggle="tab" aria-controls="tab2" aria-selected="false">Marcas ({{ $marcas->count() }})</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab3-tab" href="#tab3" role="tab" data-toggle="tab" aria-controls="tab3" aria-selected="false">Modelos ({{ $modelos->count() }})</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab4-tab" href="#tab4" role="tab" data-toggle="tab" aria-controls="tab4" aria-selected="false">Años ({{ $anios->count() }})</a>
            </li>
          </ul>
          <div class="tab-content">
            <div id="tab1" class="tab-pane fade pt-2 show active" role="tabpanel" aria-labelledby="tab1-tab">
              @if(Auth::user()->isAdmin())
              <a class="btn btn-primary btn-fill btn-xs mb-2" href="{{ route('admin.vehiculo.create') }}">
                <i class="fa fa-plus"></i> Agregar Vehículo
              </a>
              @endif

              <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Cliente</th>
                    <th scope="col" class="text-center">Marca</th>
                    <th scope="col" class="text-center">Modelo</th>
                    <th scope="col" class="text-center">Color</th>
                    <th scope="col" class="text-center">Año</th>
                    <th scope="col" class="text-center">Patentes</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($vehiculos as $d)
                    <tr>
                      <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                      <td>
                        <a href="{{ route('admin.vehiculo.show', ['vehiculo' => $d->id]) }}">
                          {{ $d->cliente->nombre() }}
                        </a>
                      </td>
                      <td>{{ $d->marca->marca }}</td>
                      <td>{{ $d->modelo->modelo }}</td>
                      <td>{{ $d->color }}</td>
                      <td>{{ $d->anio->anio() }}</td>
                      <td>{{ $d->patentes }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              
            </div><!-- .tab-pane -->
            <div id="tab2" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab2-tab" aria-expanded="false">
              @if(Auth::user()->isAdmin())
              <a class="btn btn-primary btn-fill btn-xs mb-2" href="{{ route('admin.vehiculo.marca.create') }}">
                <i class="fa fa-plus"></i> Agregar marca
              </a>
              @endif

              <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Marca</th>
                    <th scope="col" class="text-center">Vehículos</th>
                    <th scope="col" class="text-center">Agregado</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  @foreach($marcas as $d)
                    <tr>
                      <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                      <td>
                        <a href="{{ route('admin.vehiculo.marca.show', ['marca' => $d->id] )}}" title="Ver Marca">
                          {{ $d->marca }}
                        </a>
                      </td>
                      <td>{{ $d->vehiculos_count }}</td>
                      <td>{{ $d->createdAt() }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>  
            </div><!-- .tab-pane -->

            <div id="tab3" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab3-tab" aria-expanded="false">
              @if(Auth::user()->isAdmin())
              <a class="btn btn-primary btn-fill btn-xs mb-2" href="{{ route('admin.vehiculo.modelo.create') }}">
                <i class="fa fa-plus"></i> Agregar modelo
              </a>
              @endif

              <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Modelo</th>
                    <th scope="col" class="text-center">Marca</th>
                    <th scope="col" class="text-center">Vehículos</th>
                    <th scope="col" class="text-center">Agregado</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  @foreach($modelos as $d)
                    <tr>
                      <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                      <td>
                        <a href="{{ route('admin.vehiculo.modelo.show', ['modelo' => $d->id] )}}" title="Ver Modelo">
                          {{ $d->modelo }}
                        </a>
                      </td>
                      <td>{{ $d->marca->marca }}</td>
                      <td>{{ $d->vehiculos_count }}</td>
                      <td>{{ $d->createdAt() }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>  
            </div><!-- .tab-pane -->

            <div id="tab4" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab4-tab" aria-expanded="false">
              @if(Auth::user()->isAdmin())
              <a class="btn btn-primary btn-fill btn-xs mb-2" href="{{ route('admin.vehiculo.anio.create') }}">
                <i class="fa fa-plus"></i> Agregar año
              </a>
              @endif

              <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Año</th>
                    <th scope="col" class="text-center">Vehículos</th>
                    <th scope="col" class="text-center">Agregado</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  @foreach($anios as $d)
                    <tr>
                      <td scope="row" class="text-center">{{ $loop->iteration }}</td> <td>
                        <a href="{{ route('admin.vehiculo.anio.show', ['anio' => $d->id] )}}" title="Ver Año">
                          {{ $d->anio() }}
                        </a>
                      </td>
                      <td>{{ $d->vehiculos_count }}</td>
                      <td>{{ $d->createdAt() }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>  
            </div><!-- .tab-pane -->
          </div><!-- .tab-content -->
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
@endsection
