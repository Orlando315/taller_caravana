@extends('layouts.app')

@section('title', 'Vehículos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('vehiculo.index') }}"> Vehículos </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">
            <i class="fa fa-car"></i> Vehículos ({{ $vehiculos->count() }})
          </h4>
          <a class="btn btn-primary btn-fill btn-xs mb-2" href="{{ route('vehiculo.create') }}">
            <i class="fa fa-plus"></i> Agregar Vehículo
          </a>
        </div>
        <div class="card-body">
          <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
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
                    <a href="{{ route('vehiculo.show', ['vehiculo' => $d->id]) }}">
                      {{ $d->marca->marca }}
                    </a>
                  </td>
                  <td>{{ $d->modelo->modelo }}</td>
                  <td>{{ $d->color }}</td>
                  <td>{{ $d->anio->anio() }}</td>
                  <td>{{ $d->patentes }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
@endsection
