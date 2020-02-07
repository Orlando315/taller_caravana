@extends('layouts.app')

@section('title', 'Cotización - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proceso.show', ['proceso' => $cotizacion->situacion->proceso_id]) }}"> Cotización </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('admin.proceso.show', ['proceso' => $cotizacion->situacion->proceso_id]) }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
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
          <strong>Generada por</strong>
          <p class="text-muted">
            {{ $cotizacion->user->nombre() }}
          </p>
          <hr>

          <strong>Cliente</strong>
          <p class="text-muted">
            <a href="{{ route('admin.cliente.show', ['cliente' => $cotizacion->situacion->proceso->cliente_id]) }}">
              {{ $cotizacion->situacion->proceso->cliente->nombre() }}
            </a>
          </p>
          <hr>

          <strong>Vehículo</strong>
          <p class="text-muted">
            {{ $cotizacion->situacion->proceso->vehiculo->vehiculo() }}
          </p>
          <hr>

          <strong>Total</strong>
          <p class="text-muted">
            {{ $cotizacion->total(false) }}
          </p>
          <hr>

          <strong>Pagado</strong>
          <p class="text-muted">
            {{ $cotizacion->pagado() }}
          </p>

        </div>
        <div class="card-footer text-center">
          <hr>
          <small class="text-muted">
            {{ $cotizacion->created_at }}
          </small>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div>

    <div class="col-md-8">
      <div class="row">
        <div class="col-md-4">
          <div class="card card-stats">
              <div class="card-body py-1">
                <div class="row">
                  <div class="col-4">
                    <div class="icon-big text-center text-muted">
                      <i class="fa fa-credit-card"></i>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="numbers">
                      <p class="card-category">Pagos</p>
                      <p class="card-title">
                        0
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="tab1-tab" href="#tab1" role="tab" data-toggle="tab" aria-controls="tab1" aria-selected="true"><i class="fa fa-list-alt"></i> Items</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab2-tab" href="#tab2" role="tab" data-toggle="tab" aria-controls="tab2" aria-selected="false"><i class="fa fa-credit-card"></i> Pagos</a>
            </li>
          </ul>
          <div class="tab-content">
            <div id="tab1" class="tab-pane fade show active pt-2" role="tabpanel" aria-labelledby="tab1-tab">
              <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Items / Descripción</th>
                    <th class="text-center">Valor venta</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Valor final</th>
                    <th class="text-center">Precio costo</th>
                    <th class="text-center">Utilidad</th>
                    <th class="text-center">Decuento</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($cotizacion->situacionItems as $item)
                    <tr>
                      <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                      <td>{{ $item->descripcion() }}</td>
                      <td class="text-right">{{ $item->valorVenta() }}</td>
                      <td class="text-center">{{ $item->cantidad() }}</td>
                      <td class="text-right">{{ $item->total() }}</td>
                      <td class="text-right">{{ $item->costo() }}</td>
                      <td class="text-right">{{ $item->utilidad() }}</td>
                      <td class="text-right">{{ $item->descuentoText() }}</td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="2"></th>
                    <th class="text-right">{{ $cotizacion->sumValue('valor_venta', false) }}</th>
                    <th class="text-center">{{ $cotizacion->sumValue('cantidad', false, 0) }}</th>
                    <th class="text-right">{{ $cotizacion->sumValue('total', false) }}</th>
                    <th class="text-right">{{ $cotizacion->sumValue('costo', false) }}</th>
                    <th class="text-right">{{ $cotizacion->sumValue('utilidad', false) }}</th>
                    <th class="text-right">{{ $cotizacion->sumValue('total_descuento', false) }}</th>
                  </tr>
                </tfoot>
              </table>
            </div><!-- .tab-pane -->

            <div id="tab2" class="tab-pane fade" role="tabpanel" aria-labelledby="tab2-tab">

            </div><!-- .tab-pane -->
          </div><!-- .tab-content -->
        </div><!-- .card-body -->
      </div>
    </div>
  </div>

  <div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="delModalLabel">Eliminar Cotización</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <form class="col-md-10" action="{{ route('admin.cotizacion.destroy', ['cotizacion' => $cotizacion->id]) }}" method="POST">
              @csrf
              @method('DELETE')

              <p class="text-center">¿Esta seguro de eliminar esta Cotización?</p><br>

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
