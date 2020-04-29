@extends('layouts.app')

@section('title', 'Insumos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.insumos.index') }}"> Insumos </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><i class="fa fa-th-large"></i> Insumos</h4>
        </div>
        <div class="card-body">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="tab1-tab" href="#tab1" role="tab" data-toggle="tab" aria-controls="tab1" aria-selected="true">Insumos ({{ $insumos->count() }})</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab2-tab" href="#tab2" role="tab" data-toggle="tab" aria-controls="tab2" aria-selected="false">Tipos ({{ $tipos->count() }})</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab3-tab" href="#tab3" role="tab" data-toggle="tab" aria-controls="tab3" aria-selected="false">Formatos ({{ $formatos->count() }})</a>
            </li>
          </ul>
          <div class="tab-content">
            <div id="tab1" class="tab-pane fade pt-2 show active" role="tabpanel" aria-labelledby="tab1-tab">
              @if(Auth::user()->isAdmin())
                <a class="btn btn-primary btn-fill btn-xs mb-2" href="{{ route('admin.insumos.create') }}">
                  <i class="fa fa-plus"></i> Agregar Insumo
                </a>
              @endif

              <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Nombre</th>
                    <th scope="col" class="text-center">Foto</th>
                    <th scope="col" class="text-center">Stock</th>
                    <th scope="col" class="text-center">Grado</th>
                    <th scope="col" class="text-center">Tipo</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($insumos as $insumo)
                    <tr>
                      <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                      <td>
                        <a href="{{ route('admin.insumos.show', ['insumo' => $insumo->id] )}}">
                          {{ $insumo->nombre }}
                        </a>
                      </td>
                      <td class="text-center">
                        <div class="img-container">
                          <img class="img-fluid img-thumbnail" src="{{ $insumo->getPhoto() }}" alt="{{ $insumo->nombre }}" style="max-height: 75px">
                        </div>
                      </td>
                      <td class="text-right">{{ $insumo->getStock(true) }}</td>
                      <td>{{ $insumo->grado }}</td>
                      <td>{{ $insumo->tipo->tipo }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div><!-- .tab-pane -->
            <div id="tab2" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab2-tab" aria-expanded="false">
              @if(Auth::user()->isAdmin())
                <a class="btn btn-primary btn-fill btn-xs mb-2" href="{{ route('admin.tipos.create') }}">
                  <i class="fa fa-plus"></i> Agregar Tipo
                </a>
              @endif

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
                      <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                      <td>
                        <a href="{{ route('admin.tipos.show', ['tipo' => $tipo->id] )}}">
                          {{ $tipo->tipo }}
                        </a>
                      </td>
                      <td class="text-center">{{ $tipo->insumos_count }}</td>
                      <td class="text-center">{{ $tipo->created_at->format('d-m-Y H:i:s') }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div><!-- .tab-pane -->

            <div id="tab3" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab3-tab" aria-expanded="false">
              @if(Auth::user()->isAdmin())
                <a class="btn btn-primary btn-fill btn-xs mb-2" href="{{ route('admin.formatos.create') }}">
                  <i class="fa fa-plus"></i> Agregar Formato
                </a>
              @endif

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
            </div><!-- .tab-pane -->
          </div><!-- .tab-content -->
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
@endsection
