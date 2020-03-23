@extends('layouts.app')

@section('title', 'Imprevisto - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.cotizacion.show', ['cotizacion' => $imprevisto->cotizacion_id]) }}"> Imprevisto</a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.imprevisto.update', ['imprevisto' => $imprevisto->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <h4>Editar Imprevisto</h4>

            <div class="form-group">
              <label class="control-label" for="asumido">Asumido por: *</label>
              <select id="asumido" class="custom-select" name="asumido" required>
                <option value="taller"{{ old('asumido') == 'taller' ? ' selected' : '' }}>Taller (Perdida)</option>
                <option value="cliente"{{ old('asumido') == 'cliente' ? ' selected' : '' }}>Cliente</option>
              </select>
            </div>

            <div class="form-group">
              <label class="control-label" for="tipoo">Tipo: *</label>
              <select id="tipoo" class="custom-select{{ $errors->has('tipoo') ? ' is-invalid' : '' }}" name="tipo" required>
                <option value="">Seleccione...</option>
                <option value="horas"{{ old('tipo', $imprevisto->tipo) == 'horas' ? ' selected' : '' }}>Horas Hombre</option>
                <option value="repuesto"{{ old('tipo', $imprevisto->tipo) == 'repuesto' ? ' selected' : '' }}>Repuestos</option>
                <option value="insumo"{{ old('tipo', $imprevisto->tipo) == 'insumo' ? ' selected' : '' }}>Insumos</option>
                <option value="terceros"{{ old('tipo', $imprevisto->tipo) == 'terceros' ? ' selected' : '' }}>Servicios de terceros</option>
                <option value="otros"{{ old('tipo', $imprevisto->tipo) == 'otros' ? ' selected' : '' }}>Otros</option>
              </select>
            </div>

            <div class="form-group">
              <label class="control-label" for="descripcion">Descripción: *</label>
              <textarea id="descripcion" class="form-control" name="descripcion" maxlength="500">{{ old('descripcion', $imprevisto->descripcion) }}</textarea>
            </div>

            <div class="form-group">
              <label class="control-label" for="monto">Monto: *</label>
              <input id="monto" class="form-control{{ $errors->has('monto') ? ' is-invalid' : '' }}" type="number" step="0.01" min="1" max="999999999" name="monto" value="{{ old('monto', $imprevisto->monto) }}" placeholder="Monto" required>
              <small class="text-muted">Solo números</small>
            </div>
      
            @if(count($errors) > 0)
            <div class="alert alert-danger alert-important">
              <ul class="m-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif

            <div class="form-group text-right">
              <a class="btn btn-default" href="{{ route('admin.cotizacion.show', ['cotizacion' => $imprevisto->cotizacion_id]) }}"><i class="fa fa-reply"></i> Atras</a>
              <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
