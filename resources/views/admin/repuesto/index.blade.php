@extends('layouts.app')

@section('title', 'Repuestos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.repuesto.index') }}"> Repuestos </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Repuestos ({{ $repuestos->count() }})</h4>
          @if(Auth::user()->isAdmin())
            <a class="btn btn-primary btn-fill btn-xs mt-2" href="{{ route('admin.repuesto.create') }}">
              <i class="fa fa-plus"></i> Agregar Repuesto
            </a>
          @endif
        </div>
        <div class="card-body">
          <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Sistema</th>
                <th scope="col" class="text-center">Componente</th>
                <th scope="col" class="text-center">Marca</th>
                <th scope="col" class="text-center">N° de parte</th>
                <th scope="col" class="text-center">N° de OEM</th>
              </tr>
            </thead>
            <tbody>
              @foreach($repuestos as $repuesto)
                <tr>
                  <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                  <td>
                    <a href="{{ route('admin.repuesto.show', ['repuesto' => $repuesto->id] )}}">
                      {{ $repuesto->sistema }}
                    </a>
                  </td>
                  <td>{{ $repuesto->componente }}</td>
                  <td>{{ $repuesto->marca->marca }}</td>
                  <td>{{ $repuesto->nro_parte }}</td>
                  <td>{{ $repuesto->nro_oem }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
@endsection
