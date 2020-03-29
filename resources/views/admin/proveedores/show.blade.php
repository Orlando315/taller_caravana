@extends('layouts.app')

@section('title', 'Proveedor - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proveedor.index') }}"> Proveedores </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('admin.proveedor.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
      @if(Auth::user()->isAdmin())
      <a class="btn btn-success" href="{{ route('admin.proveedor.edit', ['proveedor' => $proveedor->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
      <button class="btn btn-fill btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
      @endif
    </div>
  </div>
  
  @include('partials.flash')

  <div class="row" style="margin-top: 20px">
    <div class="col-md-4">
      <div class="card card-information">
        <div class="card-header">
          <h4 class="card-title">
            Información
          </h4>
        </div><!-- .card-header -->
        <div class="card-body">
          <strong>Email</strong>
          <p class="text-muted">
            {{ $proveedor->email }}
          </p>
          <hr>

          <strong>Proveedor</strong>
          <p class="text-muted">
            {{ $proveedor->tienda }}
          </p>
          <hr>

          <strong>Vendedor</strong>
          <p class="text-muted">
            {{ $proveedor->vendedor }}
          </p>
          <hr>

          <strong>Dirección</strong>
          <p class="text-muted">
            {{ $proveedor->direccion }}
          </p>
          <hr>

          <strong>Teléfono Celular</strong>
          <p class="text-muted">
            {{ $proveedor->telefono_celular ?? 'N/A' }}
          </p>
          <hr>

          <strong>Teléfono Local</strong>
          <p class="text-muted">
            {{ $proveedor->telefono_local ?? 'N/A' }}
          </p>
          <hr>

          <strong>Descuento</strong>
          <p class="text-muted">
            {{ $proveedor->descuento() }}
          </p>
        </div>
        <div class="card-footer text-center">
          <hr>
          <small class="text-muted">
            {{ $proveedor->created_at->format('d-m-Y H:i:s') }}
          </small>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div>

    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="tab1-tab" href="#tab1" role="tab" data-toggle="tab" aria-controls="tab1" aria-selected="true">Repuestos para ({{ $vehiculos->count() }})</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab2-tab" href="#tab2" role="tab" data-toggle="tab" aria-controls="tab2" aria-selected="false">Insumos ({{ $insumos->count() }})</a>
            </li>
          </ul>
          <div class="tab-content">
            <div id="tab1" class="tab-pane fade pt-2 show active" role="tabpanel" aria-labelledby="tab1-tab">
              @if(Auth::user()->isAdmin())
                <a class="btn btn-primary btn-fill btn-xs mb-2" href="{{ route('admin.proveedor.vehiculo.create', ['proveedor' => $proveedor->id]) }}">
                  <i class="fa fa-plus"></i> Agregar vehículos
                </a>
              @endif
              
              <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Marca</th>
                    <th scope="col" class="text-center">Modelo</th>
                    <th scope="col" class="text-center">Año</th>
                    @if(Auth::user()->isAdmin())
                    <th scope="col" class="text-center">Acción</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                @foreach($vehiculos as $v)
                  <tr>
                    <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                    <td scope="col" class="text-center">{{ $v->marca->marca }}</td>
                    <td scope="col" class="text-center">{{ $v->modelo->modelo }}</td>
                    <td scope="col" class="text-center">{{ $v->anio->anio() }}</td>
                    @if(Auth::user()->isAdmin())
                    <td scope="col" class="text-center">
                      <button type="button" data-url="{{ route('admin.proveedor.vehiculo.destroy',['id' => $v->id]) }}" class="btn btn-sm btn-fill btn-danger del_vehiculo">X</button>
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
                        <a href="{{ route('admin.insumos.show', ['insumo' => $insumo->id] )}}" target="_blank">
                          {{ $insumo->nombre }}
                        </a>
                      </td>
                      <td class="text-center">
                        <div class="img-container">
                          <img class="img-fluid img-thumbnail" src="{{ $insumo->getPhoto($insumo->foto) }}" alt="{{ $insumo->nombre }}" style="max-height: 75px">
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
          </div><!-- .tab-content -->
        </div><!-- .card-body -->
      </div>
    </div>
  </div>

  @if(Auth::user()->isAdmin())
  <div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="delModalLabel">Eliminar Proveedor</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <form class="col-md-8" action="{{ route('admin.proveedor.destroy', ['proveedor' => $proveedor->id]) }}" method="POST">
              @csrf
              @method('DELETE')

              <p class="text-center">¿Esta seguro de eliminar este Proveedor?</p><br>

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

  <div id="delModalVehiculo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalVehiculoLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="delModalVehiculoLabel">Eliminar Vehículo</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <form class="col-md-8" id="form_delete_vehiculo" method="POST">
              @csrf
              @method('DELETE')

              <p class="text-center">¿Esta seguro de eliminar este Vehículo?</p><br>

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
    $('.del_vehiculo').click(function(event) {
      $('#delModalVehiculo').modal('show');
      $('#form_delete_vehiculo').attr('action',$(this).data('url'));
    });
  </script>
  @endif
@endsection
