@extends('layouts.app')

@section('title', 'Insumos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.insumos.index') }}"> Insumos </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
        <a class="btn btn-default" href="{{ route('admin.insumos.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
        @if(Auth::user()->isAdmin())
          <a class="btn btn-success" href="{{ route('admin.insumos.edit', ['insumo' => $insumo->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
          <button class="btn btn-fill btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
        @endif
    </div>
  </div>

  @if($insumo->hasLowStockAlert() && $insumo->isLowStock())
    <div class="row justify-content-md-center mt-2">
      <div class="col-md-6">
        <div class="alert alert-dismissible alert-important alert-danger m-0" role="alert">
          <strong class="text-center">El Stock actual esta por debajo del mínimo establecido.</strong>
        </div>
      </div>
    </div>
  @endif
  
  @include('partials.flash')

  <div class="row mt-2">
    <div class="col-12">
      <div class="card card-information">
        <div class="card-body">
          <div class="row">
            <div class="col-md-3 text-center">
              <figure class="figure w-100 m-0">
                <img src="{{ $insumo->getPhoto($insumo->foto) }}" class="figure-img img-thumbnail img-fluid m-0" alt="{{ $insumo->nombre }}" style="max-height: 150px;">
              </figure>
            </div>
            <div class="col-md-9">
              <div class="row">
                <div class="col-md-7">
                  <h4 class="m-0">{{ $insumo->nombre }}</h4>
                  <small class="text-muted">
                    {{ $insumo->marca }} |
                    <a href="{{ route('admin.tipos.show', ['tipo' => $insumo->tipo_id]) }}">{{ $insumo->tipo->tipo }}</a> |
                    {{ $insumo->grado }} |
                    <a href="{{ route('admin.formatos.show', ['formato' => $insumo->formato_id]) }}">{{ $insumo->formato->formato }}</a>
                  </small>
                  <p class="m-0">{{ $insumo->descripcion }}</p>
                </div>
                <div class="col-md-5">
                  <h4 class="m-0">
                    Factura
                    <button class="btn btn-link btn-info btn-xs" data-toggle="modal" data-target="#facturaModal"><i class="fa fa-search" aria-hidden="true"></i></button>
                  </h4>
                  <p class="m-0"># {{ $insumo->factura }}</p>
                  <p class="m-0">Coste: {{ optional($insumo->stockEnUso)->coste() ?? 'N/A' }}</p>
                  <p class="m-0">Venta: {{ optional($insumo->StockEnUso)->venta() ?? 'N/A' }}</p>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-12">
                  <h4 class="m-0 border-top">
                    Stock
                  </h4>
                  @if(Auth::user()->isAdmin())
                  <small><a href="{{ route('admin.insumos.stock.create', ['insumo' => $insumo->id]) }}">Agregar</a></small>
                  @endif
                  <p class="m-0">
                    Stock: {{ $insumo->getStock(true) }} |
                    Stock mínimo: {{ $insumo->minimo ?? 'N/A' }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="card card-dropdown-tabs">
        <div class="card-body">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="tab1-tab" href="#tab1" role="tab" data-toggle="tab" aria-controls="tab1" aria-selected="true">Historial de Stock ({{ $stocks->count() }})</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab2-tab" href="#tab2" role="tab" data-toggle="tab" aria-controls="tab2" aria-selected="false">Proveedores ({{ $proveedores->count() }})</a>
            </li>
          </ul>
          <div class="tab-content">
            <div id="tab1" class="tab-pane fade pt-2 show active" role="tabpanel" aria-labelledby="tab1-tab">
              @if(Auth::user()->isAdmin())
                <a class="btn btn-primary btn-fill btn-xs mb-2" href="{{ route('admin.insumos.stock.create', ['insumo' => $insumo->id]) }}">
                  <i class="fa fa-plus"></i> Agregar Stock
                </a>
              @endif
              
              <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Proveedor</th>
                    <th scope="col" class="text-center">Coste</th>
                    <th scope="col" class="text-center">Venta</th>
                    <th scope="col" class="text-center">Stock</th>
                    <th scope="col" class="text-center">Agregado</th>
                    @if(Auth::user()->isAdmin())
                      <th scope="col" class="text-center">Acción</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @foreach($stocks as $stock)
                    <tr class="{{ $stock->id == optional($insumo->stockEnUso)->id ? 'table-info' : '' }}">
                      <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                      <td>
                        <a href="{{ route('admin.proveedor.show', ['proveedor' => $stock->proveedor_id] )}}">
                          {{ $stock->proveedor->tienda }}
                        </a>
                      </td>
                      <td class="text-right">{{ $stock->coste() }}</td>
                      <td class="text-right">{{ $stock->venta() }}</td>
                      <td class="text-right">{{ $stock->stock() }}</td>
                      <td class="text-center">{{ $stock->created_at->format('d-m-Y H:i:s') }}</td>
                      @if(Auth::user()->isAdmin())
                        <td class="text-center">
                          <div class="btn-group mr-1">
                            <button type="button" class="btn btn-secondary btn-fill btn-sm dropdown-toggle m-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i></button>
                            <div class="dropdown-menu font-small-3 dropdown-menu-right">
                              <a class="dropdown-item" href="{{ route('admin.insumos.stock.edit', ['stock' => $stock->id]) }}"><i class="fa fa-pencil"></i> Editar</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item text-danger" href="#delStockModal" type="button" data-id="{{ $stock->id }}" data-toggle="modal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</a>
                            </div>
                          </div>
                        </td>
                      @endif
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div><!-- .tab-pane -->
            <div id="tab2" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab2-tab" aria-expanded="false">
              <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Proveedor</th>
                    <th scope="col" class="text-center">Vendedor</th>
                    <th scope="col" class="text-center">Email</th>
                    <th scope="col" class="text-center">Telf. Local</th>
                    <th scope="col" class="text-center">Telf. Celular</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($proveedores as $d)
                    <tr>
                      <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                      <td>
                        <a href="{{ route('admin.proveedor.show', ['proveedor' => $d->id] )}}" target="_blank" title="Ver proveedor">
                          {{ $d->tienda }}
                        </a>
                      </td>
                      <td>{{ $d->vendedor }}</td>
                      <td>{{ $d->email ?? 'N/A' }}</td>
                      <td>{{ $d->telefono_local ?? 'N/A' }}</td>
                      <td>{{ $d->telefono_celular ?? 'N/A' }}</td>
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

  <div id="facturaModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="facturaModalLabel">
    <div class="modal-dialog dialog-top" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="facturaModalLabel">Factura</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <div class="col-md-10 text-center">
              <figure class="figure w-100 m-0">
                <img src="{{ $insumo->getPhoto($insumo->foto_factura) }}" class="figure-img img-thumbnail img-fluid m-0" alt="{{ $insumo->nombre }}" style="max-height: 70vh;">
              </figure>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if(Auth::user()->isAdmin())
    <div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="delModalLabel">Eliminar Insumo</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row justify-content-md-center">
              <form class="col-md-10" action="{{ route('admin.insumos.destroy', ['insumo' => $insumo->id]) }}" method="POST">
                @csrf
                @method('DELETE')

                <p class="text-center">¿Esta seguro de eliminar este Insumo?</p><br>

                <center>
                  <button class="btn btn-fill btn-danger" type="submit">Eliminar</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </center>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="delStockModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delStockModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="delStockModalLabel">Eliminar Stock</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row justify-content-md-center">
              <form id="del-stock" class="col-md-10" action="#" method="POST">
                @csrf
                @method('DELETE')

                <p class="text-center">¿Esta seguro de eliminar este Stock?</p><br>

                <center>
                  <button class="btn btn-fill btn-danger" type="submit">Eliminar</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </center>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection

@section('scripts')
  @if(Auth::user()->isAdmin())
  <script type="text/javascript">
    $(document).ready(function() {
      $('#delStockModal').on('show.bs.modal', function (e) {
        let id = $(e.relatedTarget).data('id')

        $('#del-stock').attr('action', '{{ route("admin.insumos.stock.index") }}/'+id)
      })
    })
  </script>
  @endif
@endsection
