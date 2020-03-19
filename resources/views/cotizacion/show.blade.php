@extends('layouts.app')

@section('title', 'Cotización - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('proceso.show', ['proceso' => $cotizacion->situacion->proceso_id]) }}"> Cotización </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('proceso.show', ['proceso' => $cotizacion->situacion->proceso_id]) }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>      
      <a class="btn btn-danger" href="{{ route('cotizacion.pdf', ['cotizacion' => $cotizacion->id]) }}"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar PDF</a>
    </div>
  </div>
  
  @include('partials.flash')

  <div class="row" style="margin-top: 20px">
    <div class="col-md-3">
      <div class="card card-information">
        <div class="card-header">
          <h4 class="card-title">
            Información
          </h4>
        </div><!-- .card-header -->
        <div class="card-body">
          <strong>Generada por</strong>
          <p class="text-muted">
            {{ $cotizacion->user->nombre() }} ({{ $cotizacion->user->role() }})
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
            {{ $cotizacion->pagado(false) }}
          </p>
          <hr>

          <strong>Estatus</strong>
          <p class="text-muted">
            {!! $cotizacion->status() !!}
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

    <div class="col-md-9">
      <div class="row">
        <div class="col-md-4">
          <div class="card card-stats">
            <a class="link-pagos" href="#pagos" title="Ver pagos">
              <div class="card-body py-1">
                <div class="row">
                  <div class="col-4">
                    <div class="icon-big text-center {{ $cotizacion->hasPagos() ? 'text-danger' : 'text-muted' }}">
                      <i class="fa fa-credit-card"></i>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="numbers">
                      <p class="card-category">Pagos</p>
                      <p class="{{ $cotizacion->hasPagos() ? 'card-title' : '' }}">
                        {{ $cotizacion->hasPagos() ? $pagos->count() : '' }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card card-information">
            <div class="card-header">
              <h4 class="card-title">Descripción</h4>
            </div><!-- .card-header -->
            <div class="card-body">
              <p class="m-0">{{ $cotizacion->descripcion }}</p>
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
              <div class="tab-content proceso-tabs">
                <div id="tab1" class="tab-pane fade show active pt-2" role="tabpanel" aria-labelledby="tab1-tab">
                  <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                    <thead>
                      <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Items / Descripción</th>
                        <th class="text-center">Valor venta</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Valor final</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($cotizacion->situacionItems as $item)
                        <tr>
                          <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                          <td>
                            @if($item->type == 'horas')
                              <a tabindex="0" class="btn btn-simple btn-link" role="button" data-toggle="popover" data-trigger="focus" data-placement="top" title="Descripción" data-content="{{ $item->descripcion }}">{{ $item->titulo() }}</a>
                            @else
                              {{ $item->titulo() }}
                            @endif
                          </td>
                          <td class="text-right">{{ $item->valorVenta() }}</td>
                          <td class="text-center">{{ $item->cantidad() }}</td>
                          <td class="text-right">{{ $item->total() }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="2"></th>
                        <th class="text-right">{{ $cotizacion->sumValue('valor_venta', false) }}</th>
                        <th class="text-center">{{ $cotizacion->sumValue('cantidad', false, 0) }}</th>
                        <th class="text-right">{{ $cotizacion->sumValue('total', false) }}</th>
                      </tr>
                      <tr>
                        <td colspan="3"></td>
                        <th class="text-right">NETO</th>
                        <td class="text-right">{{ $cotizacion->neto() }}</td>
                      </tr>
                      <tr>
                        <td colspan="3"></td>
                        <td class="text-right"><strong>IVA</strong></td>
                        <td class="text-right">{{ $cotizacion->iva() }}</td>
                      </tr>
                      <tr>
                        <td colspan="3"></td>
                        <td class="text-right"><strong>TOTAL</strong></td>
                        <td class="text-right">{{ $cotizacion->total() }}</td>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- .tab-pane -->

                <div id="tab2" class="tab-pane fade pt-2" role="tabpanel" aria-labelledby="tab2-tab">
                  <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                    <thead>
                      <tr>
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-center">Pago</th>
                        <th scope="col" class="text-center">Fecha</th>
                        @if(Auth::user()->isAdmin())
                        <th scope="col" class="text-center">Acción</th>
                        @endif
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($pagos as $pago)
                        <tr>
                          <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                          <td class="text-right">{{ $pago->pago() }}</td>
                          <td class="text-center">{{ $pago->created_at->format('d-m-Y H:i:s')}}</td>
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
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      $('.link-pagos').click(function (e) {
        e.preventDefault();
        $('#tab2-tab').click()
        $('.main-panel').animate({
            scrollTop: $('.proceso-tabs').offset().top
        }, 500);
      })

      // Inicializar popovers
      $('[data-toggle="popover"]').popover()
    })
  </script>
@endsection
