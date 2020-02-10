@extends('layouts.app')

@section('title', 'Formatos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.formatos.index') }}"> Formatos </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Formatos ({{ $formatos->count() }})</h4>
          @if(Auth::user()->isAdmin())
            <a class="btn btn-primary btn-fill btn-xs mt-2" href="{{ route('admin.formatos.create') }}">
              <i class="fa fa-plus"></i> Agregar Formato
            </a>
          @endif
        </div>
        <div class="card-body">
          <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Formato</th>
                <th scope="col" class="text-center">Insumos</th>
                <th scope="col" class="text-center">Agregado</th>
              </tr>
            </thead>
            <tbody>
              @foreach($formatos as $formato)
                <tr>
                  <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                  <td>
                    <a href="{{ route('admin.formatos.show', ['formato' => $formato->id] )}}">
                      {{ $formato->formato }}
                    </a>
                  </td>
                  <td class="text-center">{{ $formato->insumos_count }}</td>
                  <td class="text-center">{{ $formato->created_at->format('d-m-Y H:i:s') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
@endsection
