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
          <a href="{{ ($preevaluaciones->count() < 12 || $preevaluacionesFotos->count() < 6) ? route('admin.preevaluacion.edit', ['proceso' => $proceso->id]) : '#preevaluaciones' }}" title="{{ ($preevaluaciones->count() < 12 || $preevaluacionesFotos->count() < 6) ? 'Editar pre-evaluación' : '' }}" >
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
                      <p class="{{  $proceso->hasPreevaluaciones() ? 'card-title' : '' }}">
                        {!!  $proceso->hasPreevaluaciones() ? $proceso->preevaluacionesStatus() : 'Agregar' !!}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-4">
          <div class="card card-stats">
            <div class="card-body py-1">
              <div class="row">
                <div class="col-4">
                  <div class="icon-big text-center text-muted">
                    <i class="fa fa-calculator"></i>
                  </div>
                </div>
                <div class="col-8">
                  <div class="numbers">
                    <p class="card-category">Cotización</p>
                    <p class="card-title">
                      -
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
  
  @if($proceso->hasPreevaluaciones())
  <div class="row">
    <div class="col-md-12">
      <div id="preevaluaciones" class="card">
        <div class="card-header">
          <h4 class="card-title">Pre-evaluación</h4>
          @if($preevaluaciones->count() < 12 || $preevaluacionesFotos->count() < 6)
            <a class="btn btn-success btn-fill btn-xs mt-2" href="{{ route('admin.preevaluacion.edit', ['proceso' => $proceso->id]) }}">
              <i class="fa fa-pencil"></i> Modificar pre-evaluación
            </a>
          @endif
        </div>
        <div class="card-body">
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
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
  @endif

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

      $('#imageModal').on('show.bs.modal', function (e) {
        let src = $(e.relatedTarget).data('url')

        $('#image').attr('src', src)
      })
    })
  </script>
@endsection

