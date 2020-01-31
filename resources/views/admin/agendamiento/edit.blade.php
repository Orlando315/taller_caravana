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
            <form action="{{ route('admin.agendamiento.update', ['agendamiento' => $agendamiento->id]) }}" method="POST">
              @csrf
              @method('PUT')

              <h4>Editar Agendamiento</h4>

              <div class="row justify-content-center group-agenda">
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="control-label">Fecha de visita: *</label>
                    <input id="fecha" type="hidden" name="fecha" vavlue="" required>
                    <span id="fecha_format">{{ $agendamiento->fecha->format('d-m-Y H:i:s') }}</span>
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
                <a class="btn btn-default" href="{{ route('admin.agendamiento.show', ['agendamiento' => $agendamiento->id]) }}"><i class="fa fa-reply"></i> Atras</a>
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
    })
  </script>
@endsection
