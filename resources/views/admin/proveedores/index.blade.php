@extends('layouts.app')

@section('title', 'Proveedores - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('dashboard') }}"> Inicio </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Proveedores ({{ $proveedores->count() }})</h4>
          @if(Auth::user()->isAdmin())
          <a class="btn btn-primary btn-fill btn-xs mt-2" href="{{ route('admin.proveedor.create') }}">
            <i class="fa fa-plus"></i> Agregar Proveedor
          </a>
          @endif
        </div>
        <div class="card-body">
          <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Tienda</th>
                <th scope="col" class="text-center">Vendedor</th>
                <th scope="col" class="text-center">Email</th>
                <th scope="col" class="text-center">Telf. Local</th>
                <th scope="col" class="text-center">Telf. Celular</th>
                <th scope="col" class="text-center">Agregado</th>
              </tr>
            </thead>
            <tbody>
              @foreach($proveedores as $d)
                <tr>
                  <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                  <td>
                    <a href="{{ route('admin.proveedor.show', ['proveedor' => $d->id] )}}" title="Ver proveedor">
                      {{ $d->tienda }}
                    </a>
                  </td>
                  <td>{{ $d->vendedor }}</td>
                  <td>{{ $d->email ?? 'N/A' }}</td>
                  <td>{{ $d->telefono_local ?? 'N/A' }}</td>
                  <td>{{ $d->telefono_celular ?? 'N/A' }}</td>
                  <td class="text-center">{{ $d->created_at->format('d-m-Y H:i:s') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
@endsection
