@extends('layouts.app')

@section('title', 'Pagos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('dashboard') }}"> Inicio </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Pagos ({{ $pagos->count() }})</h4>
        </div>
        <div class="card-body">
          <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Cliente</th>
                <th scope="col" class="text-center">Vehículo</th>
                <th scope="col" class="text-center">Pago</th>
                <th scope="col" class="text-center">Fecha</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pagos as $pago)
                <tr>
                  <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                  <td>
                    <a href="{{ route('admin.proceso.show', ['pago' => $pago->proceso_id] )}}">
                      {{ $pago->cotizacion->situacion->proceso->cliente->nombre() }}
                    </a>
                  </td>
                  <td>
                    {{ $pago->cotizacion->situacion->proceso->vehiculo->vehiculo() }}
                  </td>
                  <td class="text-right">{{ $pago->pago() }}</td>
                  <td class="text-center">{{ $pago->created_at->format('d-m-Y H:i:s')}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
@endsection
