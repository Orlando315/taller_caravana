@extends('layouts.app')

@section('title', 'Agendamientos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.agendamiento.index') }}"> Agendamientos </a>
@endsection

@section('content')
  <div class="container">

    @include('partials.flash')

    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.agendamiento.store') }}" method="POST">
              @csrf

              <h4>Generar Agendamiento</h4>
              
              <div class="row justify-content-center">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label" for="cliente">Cliente: *</label>
                    <select id="cliente" class="form-control" name="cliente" required>
                      <option value="">Seleccione...</option>
                      @foreach($clientes as $d)
                        <option value="{{ $d->id }}" {{ old('cliente') == $d->id ? 'selected' : ($cliente && $d->id == $cliente->id ? 'selected' : '') }}>
                          {{ $d->nombre() }} ({{ $d->email }})
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label" for="vehiculo">Vehículo: *</label>
                    <select id="vehiculo" class="form-control" name="vehiculo" required disabled>
                      <option value="">Seleccione...</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="row justify-content-center">
                <div class="col-md-6">
                  <div class="form-group m-0">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input id="atender" class="form-check-input" type="checkbox" name="atender" {{ old('atender') == 'on' ? 'checked' : '' }}>
                        <span class="form-check-sign"></span>
                        Atender inmediatamente
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row justify-content-center group-agenda">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Fecha de visita: *</label>
                    <input id="fecha" type="hidden" name="fecha" vavlue="" required>
                    <span id="fecha_format"></span>
                    <span class="form-text text-muted">Seleccione una fecha en el calendario.</span>
                  </div>
                </div>
              </div>

              <div class="row justify-content-center group-agenda">
                <div class="col-md-12">
                  <div id="calendar" class="border-top border-secondary pt-2 calendar-small"></div>
                </div>
              </div>

              @if(count($errors) > 0)
              <div class="alert alert-danger alert-important">
                <ul>
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif

              <div class="form-group text-right">
                <a class="btn btn-default" href="{{ route('admin.agendamiento.index') }}"><i class="fa fa-reply"></i> Atras</a>
                <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    let agendamientos = @json(Auth::user()->calendarAgendamientos());

    $(document).ready(function(){
      $('#cliente, #vehiculo').select2({
        placeholder: 'Seleccione...',
      });

      $('#cliente').on('change',function () {
        let cliente = $(this).val()

        if(!cliente){ return false }

        $.ajax({
          type: 'POST',
          url: `{{ route("admin.cliente.index") }}/${cliente}/vehiculos`,
          data: {
            _token: '{{ csrf_token() }}'
          },
          cache: false,
          dataType: 'json',
        })
        .done(function (vehiculos) {
          $('#vehiculo').html('<option value="">Seleccione...</option>');
          $.each(vehiculos, function(k, vehiculo){
            let selected = (@json(old('vehiculo')) == vehiculo.id || @json($vehiculo ? $vehiculo->id : null) == vehiculo.id) ? 'selected' : ''
            $('#vehiculo').append(`<option value="${vehiculo.id}" ${selected}>${vehiculo.marca.marca} - ${vehiculo.modelo.modelo } (${vehiculo.anio.anio })</option>`)
          })

          $('#vehiculo').prop('disabled', false)
        })
        .fail(function () {
          $('#vehiculo').prop('disabled', true)
        })
      })

      $('#cliente').change()

      $('#calendar').fullCalendar({
        defaultView: 'agendaWeek',
        themeSystem: 'bootstrap4',
        contentHeight: 'auto',
        timezone: 'local',
        allDaySlot: false,
        minTime: '07:00:00',
        maxTime: '19:00:00',
        slotLabelFormat: 'h:mm a',
        slotLabelInterval: {
          minutes: 30,
        },
        slotDuration:{
          minutes: 30,
        },
        forceEventDuration: true,
        defaultTimedEventDuration:{
          minutes: 30,
        },
        dayClick: function (date) {
          let end = date.clone()
          end.add(30, 'minutes')

          $('#fecha_format').text(`${date.format('DD-MM-YYYY H:mm:ss')}`)
          $('#fecha').val(date.format('YYYY-MM-DD H:mm:ss'))

          $('#calendar').fullCalendar('select', date.format('YYYY-MM-DD H:mm:ss'), end.format('YYYY-MM-DD H:mm:ss'))
        },
        events : agendamientos,
      });

      $('#atender').change(function (){ 
        let check = $(this).is(':checked')

        $('.group-agenda').toggle(!check)
        $('#fecha').prop('required', !check)
      })

      $('#atender').change()
    })
  </script>
@endsection
