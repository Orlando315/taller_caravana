@extends('layouts.pdf')

@section('documento')
  INSPECCIÓN
@endsection

@section('content')
  <table class="table table-sm border-0" style="width: 100%;">
    <tbody>
      <tr>
        <td class="border-0"><strong>NOMBRE DEL CLIENTE:</strong> {{ $inspeccion->proceso->cliente->nombre() }}</td>
      </tr>
      <tr>
        <td class="border-0"><strong>MARCA Y MODELO:</strong> {{ $inspeccion->proceso->vehiculo->vehiculo() }}</td>
      </tr>
      <tr>
        <td class="border-0"><strong>CELULAR:</strong> {{ $inspeccion->proceso->cliente->telefono }}</td>
      </tr>
    </tbody>
  </table>
  <table class="table table-bordered table-sm m-0" style="width: 100%;">
    <tbody>
      <tr>
        <td><strong>Combustible:</strong> {{ $inspeccion->combustible() }}</td>
        <td><strong>Observación:</strong> {{ $inspeccion->observacion }}</td>
      </tr>
    </tbody>
  </table>
  <table class="table table-bordered table-sm" style="width: 100%;">
    <tbody>
      <tr>
        <td>Radio</td>
        <td class="text-center">{!! $inspeccion->badge('radio') !!}</td>
        <td>Luces altas</td>
        <td class="text-center">{!! $inspeccion->badge('luces_altas') !!}</td>
      </tr>
      <tr>
        <td>Antena</td>
        <td class="text-center">{!! $inspeccion->badge('antena') !!}</td>
        <td>Luces bajas</td>
        <td class="text-center">{!! $inspeccion->badge('luces_bajas') !!}</td>
      </tr>
      <tr>
        <td>Pisos delanteros</td>
        <td class="text-center">{!! $inspeccion->badge('pisos_delanteros') !!}</td>
        <td>Intermitentes</td>
        <td class="text-center">{!! $inspeccion->badge('intermitentes') !!}</td>
      </tr>
      <tr>
        <td>Pisos traseros</td>
        <td class="text-center">{!! $inspeccion->badge('pisos_traseros') !!}</td>
        <td>Encendedor</td>
        <td class="text-center">{!! $inspeccion->badge('encendedor') !!}</td>
      </tr>
      <tr>
        <td>Cinturones</td>
        <td class="text-center">{!! $inspeccion->badge('cinturones') !!}</td>
        <td>Limpia parabrisas delantero</td>
        <td class="text-center">{!! $inspeccion->badge('limpia_parabrisas_delantero') !!}</td>
      </tr>
      <tr>
        <td>Tapiz</td>
        <td class="text-center">{!! $inspeccion->badge('tapiz') !!}</td>
        <td>Limpia parabrisas trasero</td>
        <td class="text-center">{!! $inspeccion->badge('limpia_parabrisas_trasero') !!}</td>
      </tr>
      <tr>
        <td>Triángulos</td>
        <td class="text-center">{!! $inspeccion->badge('triangulos') !!}</td>
        <td>Tapa de combustible</td>
        <td class="text-center">{!! $inspeccion->badge('tapa_combustible') !!}</td>
      </tr>
      <tr>
        <td>Extintor</td>
        <td class="text-center">{!! $inspeccion->badge('extintor') !!}</td>
        <td>Seguro de ruedas</td>
        <td class="text-center">{!! $inspeccion->badge('seguro_ruedas') !!}</td>
      </tr>
      <tr>
        <td>Botiquín</td>
        <td class="text-center">{!! $inspeccion->badge('botiquin') !!}</td>
        <td>Perilla interior</td>
        <td class="text-center">{!! $inspeccion->badge('perilla_interior') !!}</td>
      </tr>
      <tr>
        <td>Gata</td>
        <td class="text-center">{!! $inspeccion->badge('gata') !!}</td>
        <td>Perilla exterior</td>
        <td class="text-center">{!! $inspeccion->badge('perilla_exterior') !!}</td>
      </tr>
      <tr>
        <td>Herramientas</td>
        <td class="text-center">{!! $inspeccion->badge('herramientas') !!}</td>
        <td>Manuales</td>
        <td class="text-center">{!! $inspeccion->badge('manuales') !!}</td>
      </tr>
      <tr>
        <td>Neumático repuesto</td>
        <td class="text-center">{!! $inspeccion->badge('neumatico_repuesto') !!}</td>
        <td>Documentación</td>
        <td class="text-center">{!! $inspeccion->badge('documentación') !!}</td>
      </tr>
    </tbody>
  </table>
@endsection
