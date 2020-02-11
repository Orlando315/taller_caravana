@extends('layouts.app')

@section('title', 'Agendamientos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.agendamiento.index') }}"> Agendamientos </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Agendamientos ({{ $agendamientos }})</h4>
        </div>
        <div class="card-body">
          <div id="calendar" class="border-top border-secondary pt-2 calendar-small"></div>
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    let agendamientos = @json($agendamientosCalendar);

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
        events : agendamientos,
      });
    })
  </script>
@endsection
