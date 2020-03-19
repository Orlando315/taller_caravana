@extends('layouts.app')

@section('title', 'Cotización - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('proceso.show', ['proceso' => $situacion->proceso_id]) }}"> Cotización </a>
@endsection

@section('content')
  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-body">
          <h4>Generar cotización</h4>
          
          <h5 class="text-center">{{ $situacion->proceso->cliente->nombre().' | '.$situacion->proceso->vehiculo->vehiculo() }}</h5>

          <form action="{{ route('cotizacion.store', ['situacion' => $situacion->id]) }}" method="POST">
            @csrf
            
            <div class="form-group">
              <label for="descripcion">Descripción:</label>
              <textarea id="descripcion" class="form-control" name="descripcion" maxlength="500"></textarea>
            </div>

            <p class="text-center text-muted">Seleccione los items que deben formar parte de la cotización</p>

            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover table-sm" style="width: 100%">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Items / Descripción</th>
                    <th class="text-center">Valor venta</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Valor final</th>
                    <td class="text-center">
                      <div class="form-group m-0">
                        <div class="form-check only-check">
                          <label class="form-check-label">
                            <input id="todos" class="form-check-input" type="checkbox">
                            <span class="form-check-sign"></span>
                          </label>
                        </div>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($items as $item)
                    <tr>
                      <td scope="row">{{ $loop->iteration }}</td>
                      <td>
                        @if($item->hasDescripcion())
                          <a tabindex="0" class="btn btn-simple btn-link" role="button" data-toggle="popover" data-trigger="focus" data-placement="top" title="Descripción" data-content="{{ $item->descripcion }}">{{ $item->titulo() }}</a>
                        @else
                          {{ $item->titulo() }}
                        @endif
                      </td>
                      <td class="text-right">{{ $item->valorVenta() }}</td>
                      <td class="text-center">{{ $item->cantidad() }}</td>
                      <td class="text-right">{{ $item->total() }}</td>
                      <td class="text-center">
                        @if(!$item->status)
                        <div class="form-group m-0">
                          <div class="form-check only-check">
                            <label class="form-check-label">
                              <input class="form-check-input items-check" type="checkbox" name="items[]" value="{{ $item->id }}">
                              <span class="form-check-sign"></span>
                            </label>
                          </div>
                        </div>
                        @else
                          -
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

            @if(count($errors) > 0)
            <div class="alert alert-danger alert-important">
              <ul clasS="m-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif

            <div class="form-group text-right">
              <a class="btn btn-default" href="{{ route('proceso.show', ['proceso' => $situacion->proceso_id]) }}"><i class="fa fa-reply"></i> Atras</a>
              <button id="btn-cotizacion" class="btn btn-primary" type="submit" disabled><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form><!-- form -->
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function () {
      toggleBtn()

      $('#todos').click( function() {
        $('.items-check').prop('checked', this.checked)
        toggleBtn()
      })

      $('.items-check').click( function() {
        checkStates()
      })

      // Inicializar popovers
      $('[data-toggle="popover"]').popover()
    })

    function checkStates(){
      let allcheckCount = $('.items-check').length,
          checkedCount  = $('.items-check:checked').length;

      $('#todos').prop('checked', (allcheckCount == checkedCount))
      toggleBtn()
    }

    function toggleBtn(){
      $('#btn-cotizacion').prop('disabled', !($('.items-check:checked').length > 0))
    }
  </script>
@endsection
