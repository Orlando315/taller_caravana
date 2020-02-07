@extends('layouts.app')

@section('title', 'Procesos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('dashboard') }}"> Inicio </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Procesos ({{ $procesos->count() }})</h4>
          <a class="btn btn-primary btn-fill btn-xs mt-2" href="{{ route('admin.proceso.create') }}">
            <i class="fa fa-plus"></i> Iniciar Proceso
          </a>
        </div>
        <div class="card-body">
          <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Cliente</th>
                <th scope="col" class="text-center">Vehículo</th>
                <th scope="col" class="text-center">Agendamiento</th>
                <th scope="col" class="text-center">Pre-evaluación</th>
                <th scope="col" class="text-center">Cotización</th>
              </tr>
            </thead>
            <tbody>
              @foreach($procesos as $proceso)
                <tr>
                  <td scope="row" class="text-center">{{ $loop->index + 1 }}</td>
                  <td>
                    <a href="{{ route('admin.proceso.show', ['proceso' => $proceso->id] )}}" title="Ver proceso">
                      {{ $proceso->cliente->nombre() }}
                    </a>
                  </td>
                  <td>{{ $proceso->vehiculo->vehiculo() }}</td>
                  <td class="text-center">{{ $proceso->agendamiento ? $proceso->agendamiento->fecha() : 'N/A' }}</td>
                  <td class="text-center">{!! $proceso->preevaluacionesStatus() !!}</td>
                  <td class="text-center">{!! $proceso->cotizacionesStatus() !!}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
@endsection
