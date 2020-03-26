@extends('layouts.pdf')

@section('documento')
  COTIZACIÓN
@endsection

@section('content')
  <table class="table table-sm border-0" style="width: 100%;">
    <tbody>
      <tr>
        <td class="border-0"><strong>NOMBRE DEL CLIENTE:</strong> {{ $cotizacion->situacion->proceso->cliente->nombre() }}</td>
        <td class="border-0"><strong>CÓDIGO:</strong> {{ $cotizacion->codigo() }}</td>
      </tr>
      <tr>
        <td class="border-0"><strong>MARCA Y MODELO:</strong> {{ $cotizacion->situacion->proceso->vehiculo->vehiculo() }}</td>
        <td class="border-0"></td>
      </tr>
      <tr>
        <td class="border-0"><strong>CELULAR:</strong> {{ $cotizacion->situacion->proceso->cliente->telefono }}</td>
        <td class="border-0"></td>
      </tr>
    </tbody>
  </table>
  <table class="table table-bordered table-sm" style="width: 100%;">
    <tbody>
      <tr>
        <td colspan="4">REPUESTOS</td>
      </tr>
      <tr>
        <td class="border-top-0 border-left-0"><strong>DETALLE</strong></td>
        <td class="border-top-0 border-left-0"><strong>CANT</strong></td>
        <td class="border-top-0 border-left-0"><strong>PRECIO</strong></td>
        <td class="border-0"><strong>TOTAL</strong></td>
      </tr>
      @foreach($repuestos as $repuesto)
        <tr>
          <td>{{ $repuesto->titulo() }}</td>
          <td class="text-center">{{ $repuesto->cantidad() }}</td>
          <td class="text-right">{{ $repuesto->valorVenta() }}</td>
          <td class="text-right">{{ $repuesto->total() }}</td>
        </tr>
      @endforeach
      <tr>
        <td colspan="2" class="border-0"></td>
        <td class="text-right border-bottom-0"><strong>SUB TOTAL</strong></td>
        <td class="text-right border-bottom-0">{{ $cotizacion->sumValue('total', false, 2, 'repuesto') }}</td>
      </tr>
      <tr>
        <td colspan="4">LIBRICANTES E INSUMOS</td>
      </tr>
      <tr>
        <td class="border-top-0 border-left-0"><strong>DETALLE</strong></td>
        <td class="border-top-0 border-left-0"><strong>CANT</strong></td>
        <td class="border-top-0 border-left-0"><strong>PRECIO</strong></td>
        <td class="border-0"><strong>TOTAL</strong></td>
      </tr>
      @foreach($insumos as $insumo)
        <tr>
          <td>{{ $insumo->titulo() }}</td>
          <td class="text-center">{{ $insumo->cantidad() }}</td>
          <td class="text-right">{{ $insumo->valorVenta() }}</td>
          <td class="text-right">{{ $insumo->total() }}</td>
      </tr>
      @endforeach
      <tr>
        <td colspan="2" class="border-0"></td>
        <td class="text-right border-bottom-0"><strong>SUB TOTAL</strong></td>
        <td class="text-right border-bottom-0">{{ $cotizacion->sumValue('total', false, 2, 'insumo') }}</td>
      </tr>
      <tr>
        <td colspan="4">MANO DE OBRA</td>
      </tr>
      <tr>
        <td class="border-top-0 border-left-0"><strong>DETALLE</strong></td>
        <td class="border-top-0 border-left-0"><strong>CANT</strong></td>
        <td class="border-top-0 border-left-0"><strong>PRECIO</strong></td>
        <td class="border-0"><strong>TOTAL</strong></td>
      </tr>
      @foreach($horas as $hora)
        <tr>
          <td><small>{{ $hora->descripcion ?? 'N/A' }}</small></td>
          <td class="text-center">{{ $hora->cantidad() }}</td>
          <td class="text-right">{{ $hora->valorVenta() }}</td>
          <td class="text-right">{{ $hora->total() }}</td>
        </tr>
      @endforeach
      <tr>
        <td colspan="2" class="border-0"></td>
        <td class="text-right"><strong>SUB TOTAL</strong></td>
        <td class="text-right border-right-0">{{ $cotizacion->sumValue('total', false, 2, 'horas') }}</td>
      </tr>
      <tr>
        <td colspan="4">OTROS</td>
      </tr>
      <tr>
        <td class="border-top-0 border-left-0"><strong>DETALLE</strong></td>
        <td class="border-top-0 border-left-0"><strong>CANT</strong></td>
        <td class="border-top-0 border-left-0"><strong>PRECIO</strong></td>
        <td class="border-0"><strong>TOTAL</strong></td>
      </tr>
      @foreach($otros as $otro)
        <tr>
          <td><small>{{ $otro->descripcion ?? 'N/A' }}</small></td>
          <td class="text-center">{{ $otro->cantidad() }}</td>
          <td class="text-right">{{ $otro->valorVenta() }}</td>
          <td class="text-right">{{ $otro->total() }}</td>
        </tr>
      @endforeach
      <tr>
        <td colspan="2" class="border-0"></td>
        <td class="text-right"><strong>SUB TOTAL</strong></td>
        <td class="text-right border-right-0">{{ $cotizacion->sumValue('total', false, 2, 'horas') }}</td>
      </tr>
      @if($imprevistosCliente->count() > 0)
        <tr>
          <td colspan="4">COSTOS EXTRAS</td>
        </tr>
        <tr>
          <td class="border-top-0 border-left-0"><strong>DETALLE</strong></td>
          <td class="border-top-0 border-left-0"><strong>CANT</strong></td>
          <td class="border-top-0 border-left-0"><strong>PRECIO</strong></td>
          <td class="border-0"><strong>TOTAL</strong></td>
        </tr>
        @foreach($imprevistosCliente as $imprevisto)
          <tr>
            <td><small>{{ $imprevisto->descripcion ?? 'N/A' }}</small></td>
            <td class="text-center"></td>
            <td class="text-right"></td>
            <td class="text-right">{{ $imprevisto->monto() }}</td>
          </tr>
        @endforeach
        <tr>
          <td colspan="2" class="border-0"></td>
          <td class="text-right"><strong>SUB TOTAL</strong></td>
          <td class="text-right border-right-0">{{ $cotizacion->sumImprevistos('cliente') }}</td>
        </tr>
      @endif
      <tr>
        <td colspan="2" class="border-0"></td>
        <td class="text-right"><strong>NETO</strong></td>
        <td class="text-right border-right-0">{{ $cotizacion->neto() }}</td>
      </tr>
      @if($cotizacion->descuento)
        <tr>
          <td colspan="2" class="border-0"></td>
          <td class="text-right"><strong>DESCUENTO</strong></td>
          <td class="text-right border-right-0">{{ $cotizacion->descuento() }}</td>
        </tr>
      @endif
      <tr>
        <td colspan="2" class="border-0"></td>
        <td class="text-right"><strong>IVA</strong></td>
        <td class="text-right border-right-0">{{ $cotizacion->iva() }}</td>
      </tr>
      <tr>
        <td colspan="2" class="border-0"></td>
        <td class="text-right border-bottom-0"><strong>TOTAL</strong></td>
        <td class="text-right border-0">{{ $cotizacion->total() }}</td>
      </tr>
    </tbody>
  </table>
@endsection
