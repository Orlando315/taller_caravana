@extends('layouts.app')

@section('title', 'Agendamientos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.agendamiento.index') }}"> Agendamientos </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.agendamiento.store', ['proceso' => $proceso->id]) }}" method="POST">
            @csrf

            <h4>Generar Agendamiento</h4>
            
            <h5 class="text-center">{{ $proceso->cliente->nombre().' | '.$proceso->vehiculo->vehiculo() }}</h5>

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
              <a class="btn btn-default" href="{{ route('admin.proceso.show', ['proceso' => $proceso->id]) }}"><i class="fa fa-reply"></i> Atras</a>
              <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    let agendamientos = @json(Auth::user()->calendarAgendamientos());

    $(document).ready(function(){
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
