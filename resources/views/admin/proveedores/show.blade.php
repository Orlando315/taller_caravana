@extends('layouts.app')

@section('title', 'Proveedor - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proveedor.index') }}"> Proveedores </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('admin.proveedor.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
      <a class="btn btn-success" href="{{ route('admin.proveedor.edit', ['proveedor' => $proveedor->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
      <button class="btn btn-fill btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
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

          <strong>Tienda</strong>
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
            {{ $proveedor->telefono_celular }}
          </p>
          <hr>
           <strong>Teléfono Local</strong>
          <p class="text-muted">
            {{ $proveedor->telefono_local }}
          </p>
          <hr>
          <strong>Descuento</strong>
          <p class="text-muted">
            {{ $proveedor->descuento_convenio }}
          </p>
        </div>
        <div class="card-footer text-center">
          <hr>
          <small class="text-muted">
            {{ $proveedor->created_at }}
          </small>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div>

    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Vehículos</h4>
          <a class="btn btn-primary btn-fill btn-xs mt-2" href="{{ route('admin.proveedor.vehiculo.create', ['proveedor' => $proveedor->id]) }}">
            <i class="fa fa-plus"></i> Agregar vehículos
          </a>
        </div>
        <div class="card-body">
          <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Marca</th>
                <th scope="col" class="text-center">Modelo</th>
                <th scope="col" class="text-center">Año</th>
                <th scope="col" class="text-center">Acción</th>
              </tr>
            </thead>
            <tbody>
            @foreach($proveedor->vehiculos as $v)
              <tr>
                <td scope="row" class="text-center">{{ $loop->index + 1 }}</td>
                <td scope="col" class="text-center">{{ $v->marca->marca }}</td>
                <td scope="col" class="text-center">{{ $v->modelo->modelo }}</td>
                <td scope="col" class="text-center">{{ $v->anio_vehiculo->anio }}</td>
                <td scope="col" class="text-center">
                  <button type="button" data-url="{{ route('admin.proveedor.vehiculo.destroy',['id' => $v->id]) }}" class="btn btn-sm btn-fill btn-danger del_vehiculo">X</button>
                </td>
              </tr>
             @endforeach
            </tbody>
          </table>
        </div><!-- .card-body -->
      </div>
    </div>
  </div>

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
@endsection

@section('scripts')
  <script type="text/javascript">
    $('.del_vehiculo').click(function(event) {
      $('#delModalVehiculo').modal('show');
      $('#form_delete_vehiculo').attr('action',$(this).data('url'));
    });
</script>
@endsection