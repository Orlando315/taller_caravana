@extends('layouts.app')

@section('title', 'Clientes - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.users.index') }}"> Clientes </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Clientes ({{ $clientes->count() }})</h4>
          <a class="btn btn-primary btn-fill btn-xs mt-2" href="{{ route('admin.cliente.create') }}">
            <i class="fa fa-plus"></i> Agregar Cliente
          </a>
        </div>
        <div class="card-body">
          <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Email</th>
                <th scope="col" class="text-center">Nombre</th>
                <th scope="col" class="text-center">Teléfono</th>
                <th scope="col" class="text-center">RUT</th>
                <th scope="col" class="text-center">Vehículos</th>
              </tr>
            </thead>
            <tbody>
              @foreach($clientes as $d)
                <tr>
                  <td scope="row" class="text-center">{{ $loop->index + 1 }}</td>
                  <td>
                    <a href="{{ route('admin.cliente.show', ['cliente' => $d->id] )}}" title="Ver cliente">
                      {{ $d->user->email }}
                    </a>
                  </td>
                  <td>{{ $d->nombre() }}</td>
                  <td>{{ $d->telefono }}</td>
                  <td>{{ $d->rut }}</td>
                  <td class="text-center">{{ $d->vehiculos->count() }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
@endsection
