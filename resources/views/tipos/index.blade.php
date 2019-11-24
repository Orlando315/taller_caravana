@extends('layouts.app')

@section('title', 'Tipos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('tipos.index') }}"> Tipos </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Tipos ({{ $tipos->count() }})</h4>
          @if(Auth::user()->role != 'user')
            <a class="btn btn-primary btn-fill btn-xs mt-2" href="{{ route('tipos.create') }}">
              <i class="fa fa-plus"></i> Agregar Tipo
            </a>
          @endif
        </div>
        <div class="card-body">
          <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Tipo</th>
                <th scope="col" class="text-center">Insumos</th>
                <th scope="col" class="text-center">Agregado</th>
              </tr>
            </thead>
            <tbody>
              @foreach($tipos as $tipo)
                <tr>
                  <td scope="row" class="text-center">{{ $loop->index + 1 }}</td>
                  <td>
                    <a href="{{ route('tipos.show', ['tipo' => $tipo->id] )}}">
                      {{ $tipo->tipo }}
                    </a>
                  </td>
                  <td class="text-center">{{ $tipo->insumos_count }}</td>
                  <td class="text-center">{{ $tipo->created_at }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
@endsection
