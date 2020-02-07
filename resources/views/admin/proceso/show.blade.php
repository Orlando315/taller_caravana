@extends('layouts.app')

@section('title', 'Proceso - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proceso.index') }}"> Procesos </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('admin.proceso.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>
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
          <strong>Cliente</strong>
          <p class="text-muted">
            <a href="{{ route('admin.cliente.show', ['cliente' => $proceso->cliente_id]) }}">
              {{ $proceso->cliente->nombre() }}
            </a>
          </p>
          <hr>

          <strong>Vehículo</strong>
          <p class="text-muted">
            {{ $proceso->vehiculo->vehiculo() }}
          </p>

        </div>
        <div class="card-footer text-center">
          <hr>
          <small class="text-muted">
            {{ $proceso->created_at }}
          </small>
        </div><!-- .card-footer -->
      </div><!-- .card -->
    </div>

    <div class="col-md-8">
      <div class="row">
        <div class="col-md-4">
          @if($proceso->agendamiento)
          <a href="{{ route('admin.agendamiento.edit', ['agendamiento' => $proceso->agendamiento->id]) }}" title="Editar agendamiento">
          @else
          <a href="{{ route('admin.agendamiento.create', ['proceso' => $proceso->id]) }}" title="Agregar agendamiento">
          @endif
            <div class="card card-stats">
              <div class="card-body py-1">
                <div class="row">
                  <div class="col-4">
                    <div class="icon-big text-center {{ $proceso->agendamiento ? 'text-danger' : 'text-muted' }}">
                      <i class="fa fa-calendar"></i>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="numbers">
                      <p class="card-category">Agendamiento</p>
                      <p class="{{ $proceso->agendamiento ? 'card-title' : '' }}">
                        {{ $proceso->agendamiento ? $proceso->agendamiento->fecha() : 'Agregar' }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>

        <div class="col-md-4">
          @if($proceso->hasPreevaluaciones())
          <a href="{{ ($preevaluaciones->count() < 12 || $preevaluacionesFotos->count() < 6) ? route('admin.preevaluacion.edit', ['proceso' => $proceso->id]) : '#preevaluaciones' }}" title="{{ ($preevaluaciones->count() < 12 || $preevaluacionesFotos->count() < 6) ? 'Editar pre-evaluación' : '' }}">
          @else
          <a href="{{ ($proceso->etapa == 2) ? route('admin.preevaluacion.create', ['proceso' => $proceso->id]) : '#' }}" title="{{ ($proceso->etapa == 2) ? 'Agregar pre-evaluación' : '' }}">
          @endif
            <div class="card card-stats">
              <div class="card-body py-1">
                <div class="row">
                  <div class="col-4">
                    <div class="icon-big text-center {{ $proceso->hasPreevaluaciones() ? 'text-danger' : 'text-muted' }}">
                      <i class="fa fa-check-square-o"></i>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="numbers">
                      <p class="card-category">Pre-evaluación</p>
                      <p class="{{ $proceso->hasPreevaluaciones() ? 'card-title' : '' }}">
                        {!! $proceso->hasPreevaluaciones() ? $proceso->preevaluacionesStatus() : 'Agregar' !!}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-4">
          @if($proceso->situacion)
            <a href="{{ route('admin.situacion.edit', ['situacion' => $proceso->situacion->id]) }}" title="Editar Hoja de situación">
          @else
            <a href="{{ ($proceso->etapa == 3) ? route('admin.situacion.create', ['proceso' => $proceso->id]) : '#' }}" title="{{ ($proceso->etapa == 3) ? 'Agregar' : '' }}">
          @endif
            <div class="card card-stats">
              <div class="card-body py-1">
                <div class="row">
                  <div class="col-4">
                    <div class="icon-big text-center {{ $proceso->situacion ? 'text-danger' : 'text-muted' }}">
                      <i class="fa fa-list-alt"></i>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="numbers">
                      <p class="card-category">Hoja de situación</p>
                      <p class="{{  $proceso->situacion ? 'card-title' : '' }}">
                        {!!  $proceso->situacion ? $proceso->situacionStatus() : 'Agregar' !!}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-4">
          @if($proceso->hasCotizaciones())
            <a class="link-cotizaciones" href="#cotizaciones">
          @else
            <a href="{{ ($proceso->etapa == 4 || $proceso->etapa == 5) ? route('admin.cotizacion.create', ['situcion' => $proceso->situacion->id]) : '#' }}" title="{{ ($proceso->etapa == 4) ? 'Generar cotización' : '' }}">
          @endif
            <div class="card card-stats">
              <div class="card-body py-1">
                <div class="row">
                  <div class="col-4">
                    <div class="icon-big text-center {{ $proceso->hasCotizaciones() ? 'text-danger' : 'text-muted' }}">
                      <i class="fa fa-calculator"></i>
                    </div>
                  </div>
                  <div class="col-8">
                    <div class="numbers">
                      <p class="card-category">Cotizaciones</p>
                      <p class="{{ $proceso->hasCotizaciones() ? 'card-title' : '' }}">
                        {{ $proceso->hasCotizaciones() ? $proceso->cotizaciones->count() : 'Generar' }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
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
              <a class="nav-link active" id="tab1-tab" href="#tab1" role="tab" data-toggle="tab" aria-controls="tab1" aria-selected="true"><i class="fa fa-check-square-o"></i> Pre-evaluación</a>
            </li>
            @if($proceso->situacion)
            <li class="nav-item">
              <a class="nav-link" id="tab2-tab" href="#tab2" role="tab" data-toggle="tab" aria-controls="tab2" aria-selected="false"><i class="fa fa-list-alt"></i> Hoja de situación</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="tab3-tab" href="#tab3" role="tab" data-toggle="tab" aria-controls="tab3" aria-selected="false"><i class="fa fa-calculator"></i> Cotizaciones</a>
            </li>
            @endif
          </ul>
          <div class="tab-content">
            <div id="tab1" class="tab-pane fade show active" role="tabpanel" aria-labelledby="tab1-tab">
              @if($preevaluaciones->count() < 12 || $preevaluacionesFotos->count() < 6)
                <a class="btn btn-success btn-fill btn-xs my-2" href="{{ route('admin.preevaluacion.edit', ['proceso' => $proceso->id]) }}">
                  <i class="fa fa-pencil"></i> Modificar pre-evaluación
                </a>
              @endif
              <div class="row">
                @foreach($preevaluacionesFotos as $foto)
                  <div class="col-md-2 mb-2">
                    <div class="media-thumbs p-1 rounded">
                      <div class="media-thumbs-options mb-1">
                        <button class="btn btn-danger btn-xs btn-fill btn-delete" data-id="{{ $foto->id }}" data-type="foto" data-toggle="modal"  data-target="#delPreevaluacionModal">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                      <div class="media-thumbs-content">
                        <a href="#imageModal" data-toggle="modal" data-url="{{ asset('storage/'.$foto->foto) }}">
                          <img src="{{ asset('storage/'.$foto->foto) }}" class="img-fluid">
                        </a>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
              <div class="mt-2">
                <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                  <thead>
                    <tr>
                      <th scope="col" class="text-center">#</th>
                      <th scope="col" class="text-center">Descripción</th>
                      <th scope="col" class="text-center">Observación</th>
                      <th scope="col" class="text-center">Referencia</th>
                      <th scope="col" class="text-center">Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($preevaluaciones as $preevaluacion)
                      <tr>
                        <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $preevaluacion->descripcion }}</td>
                        <td>{{ $preevaluacion->observacion ?? 'N/A' }}</td>
                        <td class="text-right">{{ $preevaluacion->referencia() ?? 'N/A'  }}</td>
                        <td class="text-center">
                          <button class="btn btn-danger btn-sm btn-fill btn-delete" data-id="{{ $preevaluacion->id }}" data-type="preevaluacion" data-toggle="modal"  data-target="#delPreevaluacionModal">
                            <i class="fa fa-times"></i>
                          </button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div><!-- .tab-pane -->
            <div id="tab2" class="tab-pane fade" role="tabpanel" aria-labelledby="tab2-tab">
              <a class="btn btn-success btn-fill btn-xs my-2" href="{{ route('admin.situacion.edit', ['proceso' => $proceso->situacion->id]) }}">
                <i class="fa fa-pencil"></i> Modificar Hoja de situación
              </a>

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
                    <th class="text-center">Acción</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($proceso->situacion->items as $item)
                    <tr>
                      <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                      <td>{{ $item->descripcion() }}</td>
                      <td class="text-right">{{ $item->valorVenta() }}</td>
                      <td class="text-center">{{ $item->cantidad() }}</td>
                      <td class="text-right">{{ $item->total() }}</td>
                      <td class="text-right">{{ $item->costo() }}</td>
                      <td class="text-right">{{ $item->utilidad() }}</td>
                      <td class="text-right">{{ $item->descuentoText() }}</td>
                      <td class="text-center">
                        @if(!$item->status)
                        <button class="btn btn-danger btn-sm btn-fill btn-delete" data-id="{{ $item->id }}" data-type="item" data-toggle="modal"  data-target="#delSituacionModal">
                          <i class="fa fa-times"></i>
                        </button>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              
            </div><!-- .tab-pane -->
            <div id="tab3" class="tab-pane fade" role="tabpanel" aria-labelledby="tab3-tab" aria-expanded="false">
              @if($proceso->etapa == 4 || $proceso->etapa == 5)
              <a class="btn btn-primary btn-fill btn-xs my-2" href="{{ route('admin.cotizacion.create', ['situacion' => $proceso->situacion->id]) }}">
                <i class="fa fa-plus"></i> Generar cotización
              </a>
              @endif

              <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Generada por</th>
                    <th class="text-center">Items</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Pagado</th>
                    <th class="text-center">Fecha</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($proceso->cotizaciones as $cotizacion)
                    <tr>
                      <td scope="row">{{ $loop->iteration }}</td>
                      <td>
                        <a href="{{ route('admin.cotizacion.show', ['cotizacion' => $cotizacion->id]) }}">
                          {{ $cotizacion->user->nombre() }}
                        </a>
                      </td>
                      <td class="text-center">{{ $cotizacion->items->count() }}</td>
                      <td class="text-right">{{ $cotizacion->total(false) }}</td>
                      <td class="text-right">{{ $cotizacion->pagado() }}</td>
                      <td class="text-center">{{ $cotizacion->created_at->format('d-m-Y H:i:s') }}</td>
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

  <div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="delModalLabel">Eliminar Proceso</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <form class="col-md-8" action="{{ route('admin.proceso.destroy', ['proceso' => $proceso->id]) }}" method="POST">
              @csrf
              @method('DELETE')

              <p class="text-center">¿Esta seguro de eliminar este Proceso?</p><br>

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

  <div id="delPreevaluacionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delPreevaluacionModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="delPreevaluacionModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <form id="delPreevaluacion" class="col-md-8" action="#" method="POST">
              @csrf
              @method('DELETE')

              <p class="text-center">¿Esta seguro de eliminar <span id="modal-message"></span>?</p><br>

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

  <div id="delSituacionModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delSituacionModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="delSituacionModalLabel"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-md-center">
            <form id="delSituacion" class="col-md-8" action="#" method="POST">
              @csrf
              @method('DELETE')

              <p class="text-center">¿Esta seguro de eliminar este Item?</p><br>

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

  <div id="imageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="delPreevaluacionModalLabel">Imagen</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <img id="image" src="#" class="img-fluid mx-auto d-block" alt="Responsive image">
          <br>
          <center>
            <button type="button" class="btn btn-flat btn-secondary" data-dismiss="modal">Cerrar</button>
          </center>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      $('#delPreevaluacionModal').on('show.bs.modal', function (e) {
        let id = $(e.relatedTarget).data('id'),
            type = $(e.relatedTarget).data('type'),

        url = (type == 'preevaluacion' ? '{{ route("admin.preevaluacion.index") }}/' : '{{ route("admin.preevaluacion.foto.index") }}/') + id

        $('#delPreevaluacionModalLabel').text(type == 'preevaluacion' ? 'Eliminar Pre-evaluación' : 'Eliminar Foto')
        $('#modal-message').text(type == 'preevaluacion' ? 'este dato de Pre-evaluación' : 'esta Foto')
        $('#delPreevaluacion').attr('action', url)
      })

      $('#delSituacionModal').on('show.bs.modal', function (e) {
        let id = $(e.relatedTarget).data('id')

        $('#delSituacion').attr('action', '{{ route("admin.situacion.item.index") }}/'+id)
      })

      $('#imageModal').on('show.bs.modal', function (e) {
        let src = $(e.relatedTarget).data('url')

        $('#image').attr('src', src)
      })

      $('.link-cotizaciones').click(function () {
        $('#tab3-tab').click()
      })
    })
  </script>
@endsection

