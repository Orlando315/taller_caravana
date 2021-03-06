@extends('layouts.app')

@section('title', 'Situación - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proceso.show', ['proceso' => $situacion->proceso_id]) }}"> Situación </a> @endsection

@section('content')
  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-body">
          
          <h4>Editar Hoja de situación</h4>
          
          <h5 class="text-center">{{ $situacion->proceso->cliente->nombre().' | '.$situacion->proceso->vehiculo->vehiculo() }}</h5>
          
          <form id="form-load-item" action="#" method="POST">
            <div class="row justify-content-center">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="control-label" for="tipo">Tipo: *</label>
                  <select id="tipo" class="custom-select" required>
                    <option value="insumo">Insumos</option>
                    <option value="repuesto">Repuestos</option>
                    <option value="horas">Horas hombre</option>
                    <option value="otros">Otros</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row set-repuesto">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="search-sistema">Sistema:</label>
                  <select id="search-sistema" class="form-control" style="width: 100%">
                    <option value="">Seleccione...</option>
                    @foreach($repuestoSistemas as $sistema)
                      <option value="{{ $sistema->sistema }}">{{ $sistema->sistema }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="search-componente">Componente:</label>
                  <select id="search-componente" class="form-control" style="width: 100%">
                    <option value="">Seleccione...</option>
                    @foreach($repuestoComponentes as $componente)
                      <option value="{{ $componente->componente }}">{{ $componente->componente }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="search-anio">Año:</label>
                  <select id="search-anio" class="form-control" style="width: 100%">
                    <option value="">Seleccione...</option>
                    @foreach($repuestoAnios as $anio)
                      <option value="{{ $anio->anio }}">{{ $anio->anio }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="search-motor">Motor:</label>
                  <select id="search-motor" class="form-control" style="width: 100%">
                    <option value="">Seleccione...</option>
                    @foreach($repuestoMotores as $motor)
                      <option value="{{ $motor->motor }}">{{ $motor->motor }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>

            <div class="row set-insumo">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="search-insumo-marca">Marca:</label>
                  <select id="search-insumo-marca" class="form-control" style="width: 100%">
                    <option value="">Seleccione...</option>
                    @foreach($insumoMarcas as $insumoMarca)
                      <option value="{{ $insumoMarca->marca }}">{{ $insumoMarca->marca }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="search-insumo-grado">Grado:</label>
                  <select id="search-insumo-grado" class="form-control" style="width: 100%">
                    <option value="">Seleccione...</option>
                    @foreach($insumoGrados as $insumoGrado)
                      <option value="{{ $insumoGrado->grado }}">{{ $insumoGrado->grado }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="search-insumo-formato">Formato:</label>
                  <select id="search-insumo-formato" class="form-control" style="width: 100%">
                    <option value="">Seleccione...</option>
                    @foreach($insumoFormatos as $insumoFormato)
                      <option value="{{ $insumoFormato->id }}">{{ $insumoFormato->formato }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-5">
                <div class="form-group set-insumo">
                  <label for="insumo">Insumo:</label>
                  <select id="insumo" class="form-control">
                    <option value="">Seleccione...</option>
                  </select>
                </div>

                <div class="form-group set-repuesto" style="display: none;">
                  <label for="repuesto">Repuesto:</label>
                  <select id="repuesto" class="form-control" style="width: 100%">
                    <option value="">Seleccione...</option>
                  </select>
                  <button class="btn btn-simple btn-link btn-sm" type="button" data-toggle="modal" data-target="#addRepuestoModal">
                    <i class="fa fa-plus" aria-hidden="true"></i> Agregar repuesto
                  </button>
                </div>

                <div class="form-group set-otros" style="display: none">
                  <label for="venta">Valor de venta:</label>
                  <input id="venta" class="form-control" type="number" min="0" max="9999999">
                </div>
              </div><!-- .col-md-5 -->

              <div class="col-md-3">
                <div class="form-group">
                  <label for="cantidad">Cantidad:</label>
                  <input id="cantidad" class="form-control" type="number" min="1" max="9999" step="0.1" required>
                </div>
              </div><!-- .col-md-3 -->

              <div class="col-md-4">
                <fieldset id="set-descuento">
                  <div class="form-group m-0">
                    <label for="descuento">Descuento:</label>
                    <input id="descuento" class="form-control" type="number" min="0">
                  </div>

                  <div class="form-group m-0">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input id="porcentaje" class="form-check-input" type="checkbox">
                        <span class="form-check-sign"></span>
                        Descuento en procentaje
                      </label>
                    </div>
                  </div>
                </fieldset>
              </div>
            </div><!-- .row -->

            <div id="otros-descripcion" class="row">
              <div class="col-12 pt-0">
                <div class="form-group m-0">
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" class="form-control" maxlength="500"></textarea>
                </div>
              </div>
            </div>

            <div id="item-information" class="row" style="display: none">
              <div class="col-12">
                <p class="m-0"><strong>Costo total:</strong> <span class="selected-costo">-</span></p>
                <p class="m-0"><strong>Valor venta:</strong> <span class="selected-venta">-</span></p>
                <p class="m-0"><strong>Stock disponible:</strong> <span class="selected-stock">-</span></p>
              </div>
            </div>

            <div class="alert alert-danger alert-important" style="display: none">
              <ul class="m-0 form-errors-search-items">
              </ul>
            </div>

            <center>
              <button class="btn btn-primary btn-fill btn-sm" type="submit"><i class="fa fa-plus"></i> Agregar item</button>
            </center>
          </form><!-- form -->
          
          <hr>

          <form id="form-update-items" action="{{ route('admin.situacion.update', ['Situacion' => $situacion->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="deleted[]">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover table-sm font-small m-0" style="width: 100%">
                <thead>
                  <tr>
                    <td colspan="8">REPUESTOS</td>
                  </tr>
                  <tr>
                    <th style="width: 5%"></th>
                    <th style="width: 40%">DETALLE</th>
                    <th style="width: 10%">PRECIO COSTO</th>
                    <th style="width: 10%">UTILIDAD</th>
                    <th style="width: 10%">DESCUENTO</th>
                    <th style="width: 5%">CANT</th>
                    <th style="width: 10%">PRECIO</th>
                    <th style="width: 10%">TOTAL</th>
                  </tr>
                </thead>
                <tbody id="tbody-repuesto">
                  @foreach($situacionRepuestos as $r)
                    <tr style="background-color: rgba(0,0,0,.05);">
                      <td></td>
                      <td>{{ $r->titulo() }}</td>
                      <td class="text-right">{{ $r->costo() }}</td>
                      <td class="text-right">{{ $r->utilidad() }}</td>
                      <td class="text-right"></td>
                      <td class="text-center">{{ $r->cantidad() }}</td>
                      <td class="text-right">{{ $r->valorVenta() }}</td>
                      <td class="text-right">{{ $r->total() }}</td>
                    </tr>
                  @endforeach
                  <tr style="background-color: transparent;">
                    <td colspan="8" class="text-center">
                      Nuevos items
                    </td>
                  </tr>
                  @if(old('datos'))
                    @foreach(old('datos') as $dato)
                      @continue(old('datos.'.$loop->iteration.'.type') != 'repuesto')
                      
                      <tr id="tr-{{ $loop->iteration }}" class="tr-dato" data-type="repuesto" data-item="old('datos.'.$loop->iteration.'.item')" data-cantidad="{{ old('datos.'.$loop->iteration.'.cantidad') }}">
                        <td>
                          <button class="btn btn-danger btn-fill btn-xs btn-delete" type="button" role="button" data-id="{{ $loop->iteration }}"><i class="fa fa-trash"></i></button>
                        </td>
                        <td>
                          {{ old('datos.'.$loop->iteration.'.titulo') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][item]" value="{{ old('datos.'.$loop->iteration.'.item') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][type]" value="{{ old('datos.'.$loop->iteration.'.type') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][titulo]" value="{{ old('datos.'.$loop->iteration.'.titulo') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descripcion]" value="{{ old('datos.'.$loop->iteration.'.descripcion') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.costo') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][costo]" value="{{ old('datos.'.$loop->iteration.'.costo') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.utilidad') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][utilidad]" value="{{ old('datos.'.$loop->iteration.'.utilidad') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.descuento_text') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descuento_text]" value="{{ old('datos.'.$loop->iteration.'.descuento_text') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descuento_type]" value="{{ old('datos.'.$loop->iteration.'.descuento_type') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descuento]" value="{{ old('datos.'.$loop->iteration.'.descuento') }}">
                        </td>
                        <td class="text-center">
                          {{ old('datos.'.$loop->iteration.'.cantidad') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][cantidad]" value="{{ old('datos.'.$loop->iteration.'.cantidad') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.valor_venta') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][valor_venta]" value="{{ old('datos.'.$loop->iteration.'.valor_venta') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.total') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][total]" value="{{ old('datos.'.$loop->iteration.'.total') }}">
                        </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>

              <table class="table table-striped table-bordered table-hover table-sm font-small m-0" style="width: 100%">
                <thead>
                  <tr>
                    <td colspan="8">LIBRICANTES E INSUMOS</td>
                  </tr>
                  <tr>
                    <th style="width: 5%"></th>
                    <th style="width: 40%">DETALLE</th>
                    <th style="width: 10%">PRECIO COSTO</th>
                    <th style="width: 10%">UTILIDAD</th>
                    <th style="width: 10%">DESCUENTO</th>
                    <th style="width: 5%">CANT</th>
                    <th style="width: 10%">PRECIO</th>
                    <th style="width: 10%">TOTAL</th>
                  </tr>
                </thead>
                <tbody id="tbody-insumo">
                  @foreach($situacionInsumos as $i)
                    <tr style="background-color: rgba(0,0,0,.05);">
                      <td></td>
                      <td>{{ $i->titulo() }}</td>
                      <td class="text-right">{{ $i->costo() }}</td>
                      <td class="text-right">{{ $i->utilidad() }}</td>
                      <td class="text-right"></td>
                      <td class="text-center">{{ $i->cantidad() }}</td>
                      <td class="text-right">{{ $i->valorVenta() }}</td>
                      <td class="text-right">{{ $i->total() }}</td>
                    </tr>
                  @endforeach
                  <tr style="background-color: transparent;">
                    <td colspan="8" class="text-center">
                      Nuevos items
                    </td>
                  </tr>
                  @if(old('datos'))
                    @foreach(old('datos') as $dato)
                      @continue(old('datos.'.$loop->iteration.'.type') != 'insumo')
                      
                      <tr id="tr-{{ $loop->iteration }}" class="tr-dato" data-type="insumo" data-item="old('datos.'.$loop->iteration.'.item')" data-cantidad="{{ old('datos.'.$loop->iteration.'.cantidad') }}">
                        <td>
                          <button class="btn btn-danger btn-fill btn-xs btn-delete" type="button" role="button" data-id="{{ $loop->iteration }}"><i class="fa fa-trash"></i></button>
                        </td>
                        <td>
                          {{ old('datos.'.$loop->iteration.'.titulo') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][item]" value="{{ old('datos.'.$loop->iteration.'.item') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][type]" value="{{ old('datos.'.$loop->iteration.'.type') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][titulo]" value="{{ old('datos.'.$loop->iteration.'.titulo') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descripcion]" value="{{ old('datos.'.$loop->iteration.'.descripcion') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.costo') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][costo]" value="{{ old('datos.'.$loop->iteration.'.costo') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.utilidad') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][utilidad]" value="{{ old('datos.'.$loop->iteration.'.utilidad') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.descuento_text') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descuento_text]" value="{{ old('datos.'.$loop->iteration.'.descuento_text') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descuento_type]" value="{{ old('datos.'.$loop->iteration.'.descuento_type') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descuento]" value="{{ old('datos.'.$loop->iteration.'.descuento') }}">
                        </td>
                        <td class="text-center">
                          {{ old('datos.'.$loop->iteration.'.cantidad') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][cantidad]" value="{{ old('datos.'.$loop->iteration.'.cantidad') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.valor_venta') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][valor_venta]" value="{{ old('datos.'.$loop->iteration.'.valor_venta') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.total') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][total]" value="{{ old('datos.'.$loop->iteration.'.total') }}">
                        </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>

              <table class="table table-striped table-bordered table-hover table-sm font-small m-0" style="width: 100%">
                <thead>
                  <tr>
                    <td colspan="8">MANO DE OBRA</td>
                  </tr>
                  <tr>
                    <th style="width: 5%"></th>
                    <th style="width: 40%">DETALLE</th>
                    <th style="width: 10%">PRECIO COSTO</th>
                    <th style="width: 10%">UTILIDAD</th>
                    <th style="width: 10%">DESCUENTO</th>
                    <th style="width: 5%">CANT</th>
                    <th style="width: 10%">PRECIO</th>
                    <th style="width: 10%">TOTAL</th>
                  </tr>
                </thead>
                <tbody id="tbody-horas">
                  @foreach($situacionHoras as $h)
                    <tr style="background-color: rgba(0,0,0,.05);">
                      <td></td>
                      <td><p class="m-0"><small>{{ $h->descripcion }}</small></p></td>
                      <td class="text-right">{{ $h->costo() }}</td>
                      <td class="text-right">{{ $h->utilidad() }}</td>
                      <td class="text-right">{{ $h->descuentoText() }}</td>
                      <td class="text-center">{{ $h->cantidad() }}</td>
                      <td class="text-right">{{ $h->valorVenta() }}</td>
                      <td class="text-right">{{ $h->total() }}</td>
                    </tr>
                  @endforeach
                  <tr style="background-color: transparent;">
                    <td colspan="8" class="text-center">
                      Nuevos items
                    </td>
                  </tr>
                  @if(old('datos'))
                    @foreach(old('datos') as $dato)
                      @continue(old('datos.'.$loop->iteration.'.type') != 'horas')
                      
                      <tr id="tr-{{ $loop->iteration }}" class="tr-dato" data-type="horas" data-item="old('datos.'.$loop->iteration.'.item')" data-cantidad="{{ old('datos.'.$loop->iteration.'.cantidad') }}">
                        <td>
                          <button class="btn btn-danger btn-fill btn-xs btn-delete" type="button" role="button" data-id="{{ $loop->iteration }}"><i class="fa fa-trash"></i></button>
                        </td>
                        <td>
                          {{ old('datos.'.$loop->iteration.'.titulo') }}
                          <p class="m-0"><small>{{ old('datos.'.$loop->iteration.'.descripcion') }}</small></p>
                          <input type="hidden" name="datos[{{ $loop->iteration }}][item]" value="{{ old('datos.'.$loop->iteration.'.item') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][type]" value="{{ old('datos.'.$loop->iteration.'.type') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][titulo]" value="{{ old('datos.'.$loop->iteration.'.titulo') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descripcion]" value="{{ old('datos.'.$loop->iteration.'.descripcion') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.costo') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][costo]" value="{{ old('datos.'.$loop->iteration.'.costo') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.utilidad') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][utilidad]" value="{{ old('datos.'.$loop->iteration.'.utilidad') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.descuento_text') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descuento_text]" value="{{ old('datos.'.$loop->iteration.'.descuento_text') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descuento_type]" value="{{ old('datos.'.$loop->iteration.'.descuento_type') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descuento]" value="{{ old('datos.'.$loop->iteration.'.descuento') }}">
                        </td>
                        <td class="text-center">
                          {{ old('datos.'.$loop->iteration.'.cantidad') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][cantidad]" value="{{ old('datos.'.$loop->iteration.'.cantidad') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.valor_venta') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][valor_venta]" value="{{ old('datos.'.$loop->iteration.'.valor_venta') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.total') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][total]" value="{{ old('datos.'.$loop->iteration.'.total') }}">
                        </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>

              <table class="table table-striped table-bordered table-hover table-sm font-small" style="width: 100%">
                <thead>
                  <tr>
                    <td colspan="8">OTROS</td>
                  </tr>
                  <tr>
                    <th style="width: 5%"></th>
                    <th style="width: 40%">DETALLE</th>
                    <th style="width: 10%">PRECIO COSTO</th>
                    <th style="width: 10%">UTILIDAD</th>
                    <th style="width: 10%">DESCUENTO</th>
                    <th style="width: 5%">CANT</th>
                    <th style="width: 10%">PRECIO</th>
                    <th style="width: 10%">TOTAL</th>
                  </tr>
                </thead>
                <tbody id="tbody-otros">
                  @foreach($situacionOtros as $o)
                    <tr style="background-color: rgba(0,0,0,.05);">
                      <td></td>
                      <td><p class="m-0"><small>{{ $o->descripcion }}</small></p></td>
                      <td class="text-right">{{ $o->costo() }}</td>
                      <td class="text-right">{{ $o->utilidad() }}</td>
                      <td class="text-right">{{ $o->descuentoText() }}</td>
                      <td class="text-center">{{ $o->cantidad() }}</td>
                      <td class="text-right">{{ $o->valorVenta() }}</td>
                      <td class="text-right">{{ $o->total() }}</td>
                    </tr>
                  @endforeach
                  <tr style="background-color: transparent;">
                    <td colspan="8" class="text-center">
                      Nuevos items
                    </td>
                  </tr>
                  @if(old('datos'))
                    @foreach(old('datos') as $dato)
                      @continue(old('datos.'.$loop->iteration.'.type') != 'otros')
                      
                      <tr id="tr-{{ $loop->iteration }}" class="tr-dato" data-type="otros" data-item="old('datos.'.$loop->iteration.'.item')" data-cantidad="{{ old('datos.'.$loop->iteration.'.cantidad') }}">
                        <td>
                          <button class="btn btn-danger btn-fill btn-xs btn-delete" type="button" role="button" data-id="{{ $loop->iteration }}"><i class="fa fa-trash"></i></button>
                        </td>
                        <td>
                          {{ old('datos.'.$loop->iteration.'.titulo') }}
                          <p class="m-0"><small>{{ old('datos.'.$loop->iteration.'.descripcion') }}</small></p>
                          <input type="hidden" name="datos[{{ $loop->iteration }}][item]" value="{{ old('datos.'.$loop->iteration.'.item') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][type]" value="{{ old('datos.'.$loop->iteration.'.type') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][titulo]" value="{{ old('datos.'.$loop->iteration.'.titulo') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descripcion]" value="{{ old('datos.'.$loop->iteration.'.descripcion') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.costo') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][costo]" value="{{ old('datos.'.$loop->iteration.'.costo') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.utilidad') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][utilidad]" value="{{ old('datos.'.$loop->iteration.'.utilidad') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.descuento_text') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descuento_text]" value="{{ old('datos.'.$loop->iteration.'.descuento_text') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descuento_type]" value="{{ old('datos.'.$loop->iteration.'.descuento_type') }}">
                          <input type="hidden" name="datos[{{ $loop->iteration }}][descuento]" value="{{ old('datos.'.$loop->iteration.'.descuento') }}">
                        </td>
                        <td class="text-center">
                          {{ old('datos.'.$loop->iteration.'.cantidad') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][cantidad]" value="{{ old('datos.'.$loop->iteration.'.cantidad') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.valor_venta') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][valor_venta]" value="{{ old('datos.'.$loop->iteration.'.valor_venta') }}">
                        </td>
                        <td class="text-right">
                          {{ old('datos.'.$loop->iteration.'.total') }}
                          <input type="hidden" name="datos[{{ $loop->iteration }}][total]" value="{{ old('datos.'.$loop->iteration.'.total') }}">
                        </td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
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
              <a class="btn btn-default" href="{{ route('admin.proceso.show', ['proceso' => $situacion->proceso->id]) }}"><i class="fa fa-reply"></i> Atras</a>
              <button id="btn-situacion" class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form><!-- form -->
        </div><!-- .card-body -->
      </div>
    </div>
  </div>

  <div id="addRepuestoModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addRepuestoModalLabel">
    <div class="modal-dialog dialog-top modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="addRepuestoModalLabel">Agregar Repuesto</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="repuesto-form" class="card border-0" action="{{ route('admin.repuesto.store') }}" method="POST">
            <input type="hidden" name="marca" value="{{ $situacion->proceso->vehiculo->vehiculo_marca_id }}">
            <input type="hidden" name="modelo" value="{{ $situacion->proceso->vehiculo->vehiculo_modelo_id }}">
            @csrf
          
            <fieldset>
              <legend>Datos del Repuesto</legend>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="repuesto-año">Año: *</label>
                    <input id="repuesto-año" class="form-control" type="number" name="año" min="0" step="1" max="9999" placeholder="Año" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="repuesto-motor">Motor (cc): *</label>
                    <input id="repuesto-motor" class="form-control" type="number" min="0" max="9999" name="motor" placeholder="Motor" required>
                    <small class="text-muted">Solo números</small>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="repuesto-sistema">Sistema: *</label>
                    <input id="repuesto-sistema" class="form-control" type="text" name="sistema" maxlength="50" placeholder="Sistema" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="repuesto-componente">Componente: *</label>
                    <input id="repuesto-componente" class="form-control" type="text" name="componente" maxlength="50" placeholder="Componente" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="repuesto-nro_parte">N° parte:</label>
                    <input id="repuesto-nro_parte" class="form-control" type="text" name="nro_parte" maxlength="50" placeholder="N° parte">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="repuesto-nro_oem">N° OEM:</label>
                    <input id="repuesto-nro_oem" class="form-control" type="text" name="nro_oem" maxlength="50" placeholder="N° OEM">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="repuesto-marca_oem">Marca OEM: *</label>
                    <input id="repuesto-marca_oem" class="form-control" type="text" name="marca_oem" maxlength="50" placeholder="Marca OEM" required>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="repuesto-stock">Stock:</label>
                    <input id="repuesto-stock" class="form-control" type="number" name="stock" min="0" max="9999" placeholder="Stock">
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="repuesto-procedencia">Procedencia: *</label>
                    <select id="repuesto-procedencia" class="form-control" name="procedencia" required style="width: 100%">
                      <option>Seleccione...</option>
                      <option value="local">Local</option>
                      <option value="nacional">Nacional</option>
                      <option value="internacional">Internacional</option>
                    </select>
                  </div>
                </div>
              </div>
            </fieldset>

            <fieldset>
              <legend class="title-legend">Procedencia: <span id="procedencia-title"></span></legend>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="repuesto-moneda">Moneda: *</label>
                    <select id="repuesto-moneda" class="custom-select" name="moneda" required>
                      <option value="">Seleccione...</option>
                      <option value="peso">Peso chileno</option>
                      <option value="dolar">Dólar</option>
                      <option value="euro">Euro</option>
                    </select>
                  </div>
                  <div class="form-group m-0" style="display: none">
                    <label class="control-label" for="repuesto-moneda-valor">Especificar valor: *</label>
                    <input id="repuesto-moneda-valor" class="form-control" type="number" step="0.01" min="0" max="99999999" name="moneda_valor" placeholder="Especificar valor">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="repuesto-costo">Costo:</label>
                    <input id="repuesto-costo" class="form-control" type="number" step="0.01" min="0" max="99999999" name="costo" maxlength="50" placeholder="Costo">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="repuesto-generales">Gastos generales:</label>
                    <input id="repuesto-generales" class="form-control" type="number" step="0.01" min="0" max="99999999" name="generales" value="1.3" maxlength="50" placeholder="Gastos generales">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group" style="display: none">
                    <label class="control-label" for="repuesto-envio">Envio:</label>
                    <input id="repuesto-envio" class="form-control field-nacional" type="number" step="0.01" min="0" max="99999999" name="envio" placeholder="Envio">
                  </div>
                  <div class="form-group m-0" style="display: none">
                    <label class="control-label" for="repuesto-impuestos-internacional">Impuestos:</label>
                    <input id="repuesto-impuestos-internacional" class="form-control field-internacional" type="number" step="0.01" min="0" max="99999999" name="impuestos" value="1.25" placeholder="Especificar">
                  </div>
                </div>
              </div>

              <div class="row group-field-internacional" style="display:none">
                <div class="col-md-3">
                  <div class="form-group" style="display: none">
                    <label class="control-label" for="repuesto-envio1-internacional">Envio 1:</label>
                    <input id="repuesto-envio1-internacional" class="form-control field-internacional" type="number" step="0.01" min="0" max="99999999" name="envio1" placeholder="Envio 1">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group" style="display: none">
                    <label class="control-label" for="repuesto-envio2-internacional">Envio 2:</label>
                    <input id="repuesto-envio2-internacional" class="form-control field-internacional" type="number" step="0.01" min="0" max="99999999" name="envio2" placeholder="Envio 2">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group" style="display: none">
                    <label class="control-label" for="repuesto-casilla-internacional">Gastos casilla:</label>
                    <input id="repuesto-casilla-internacional" class="form-control field-internacional" type="number" step="0.01" min="0" max="99999999" name="casilla" placeholder="Gastos casilla">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="repuesto-venta">Precio de venta: *</label>
                    <input id="repuesto-venta" class="form-control" type="number" step="0.01" min="0" max="99999999" name="venta" maxlength="50" placeholder="Venta" required>
                    <button class="btn btn-simple btn-link btn-sm btn-sugerir" type="button" role="button">
                      <i class="fa fa-calculator" aria-hidden="true"></i> Sugerir precio
                    </button>
                  </div>
                </div>
              </div>
            </fieldset>

            <fieldset>
              <legend class="title-legend">Otros:</legend>

              <div class="form-group">
                <label for="repuesto-comentarios">Comentarios:</label>
                <textarea id="repuesto-comentarios" class="form-control" name="comentarios" maxlength="250"></textarea>
              </div>
            </fieldset>

            <div class="alert alert-danger alert-important alert-repuesto" style="display: none">
              <ul class="m-0 form-errors-repuesto">
              </ul>
            </div>

            <center>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button id="vehiculo-submit" class="btn btn-fill btn-primary" type="submit">Guardar</button>
            </center>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    const PORCENTAJE_GANANCIA = @json(Auth::user()->getGlobalGanancia());

    $(document).ready(function () {
      $('#insumo, #repuesto').select2({
        placeholder: 'Seleccione...',
      });

      $('tbody[id^="tbody-"]').on('click', '.btn-delete', deleteRow)

      $('#porcentaje').change(function (){ 
        let check = $(this).is(':checked')

        $('#descuento').attr('max', check ? 100 : 99999999);
      })

      $('#tipo').change(function () {
        let tipo = $(this).val()

        $('.set-insumo').toggle(tipo == 'insumo')
        $('.set-repuesto').toggle(tipo == 'repuesto')
        $('.set-otros, #otros-descripcion').toggle(tipo == 'horas' || tipo == 'otros')

        $('#insumo').prop('required', tipo == 'insumo')
        $('#repuesto').prop('required', tipo == 'repuesto')
        $('#venta').prop('required', tipo == 'horas' || tipo == 'otros')
        $('#set-descuento').prop('disabled', tipo != 'horas')

        $('#item-information').toggle(tipo == 'insumo' || tipo == 'repuesto')

        if(tipo == 'insumo' || tipo == 'repuesto'){
          $(`#${tipo}`).val(null).trigger('change');
        }

        $('.selected-venta,.selected-costo,.selected-stock').text('-')
      })

      $('#tipo').change()

      $('#form-load-item').submit(function (e) {
        e.preventDefault()

        $('#btn-situacion').prop('disabled', false)

        let tipo = $('#tipo').val();
        let useSelect  = (tipo == 'insumo' || tipo == 'repuesto')

        // Solo cuando es Insumo o Repuesto
        let value = useSelect ? $(`#${tipo}`).val() : null
        let option = useSelect ? $(`#${tipo} option[value="${value}"]`) : null

        let cantidad = $('#cantidad').val();
        let venta = (useSelect && $(option).data('venta')) ? $(option).data('venta') : +$('#venta').val();
        venta = typeof venta == 'number' ? venta : +(venta.replace(',', '.'));

        if(useSelect && checkStock(tipo, cantidad, option)){
          showErrors(['La cantidad ingresada supera el stock disponible actualmente'], '.form-errors-search-items');
          return false;
        }

        let total = (venta * cantidad)
        let costo = (useSelect && $(option).data('costo')) ? (+$(option).data('costo') * cantidad) : 0
        let utilidad = 0
        let item = {
            item: useSelect ? value : '',
            type: tipo,
            descripcion: $('#descripcion').val(),
            titulo: useSelect ? $(option).data('titulo') : (tipo == 'horas' ? 'Horas hombre' : 'Otros'),
            venta: venta,
            cantidad: cantidad,
            total: total,
            costo: costo,
            utilidad: useSelect ? (total - costo) : (venta * cantidad),
            descuento: {
              text: '',
              tipo: '',
              cantidad: '',
            }
          }

        if(tipo == 'horas'){
          let descuento = $('#descuento').val() ? +$('#descuento').val() : 0
          let tipoPorcentaje = $('#porcentaje').is(':checked')
          let totalDescuento = tipoPorcentaje ? ((total * descuento) / 100) : descuento

          item.descuento.text = tipoPorcentaje ? `${totalDescuento.toLocaleString('de-DE')} (${descuento}%)` : totalDescuento.toLocaleString('de-DE')
          item.descuento.tipo = tipoPorcentaje
          item.descuento.cantidad = descuento
        }

        let index = ($('.tr-dato').length + 1)

        $(`#tbody-${tipo}`).append(dato(index, item))

        $('#cantidad, #descuento, #venta, #descripcion, #precio').val('')
        $('#porcentaje').prop('checked', false)
      })// Send form

      toggleBtn()

      $('#insumo, #repuesto').change(function () {
        let val = $(this).val();
        let type = $(this).attr('id');

        if(!val){ return false }
        
        let option = $(this).find(`option[value="${val}"]`),
            venta = option.data('venta'),
            costo = option.data('costo'),
            stock = getStock(type, option);

        if(!venta && !costo){ return; }

        numberVenta = +(typeof venta == 'number' ? +(venta.toFixed(2)) : venta.replace(',', '.'));
        numberCosto = +(typeof costo == 'number' ? +(costo.toFixed(2)) : costo.replace(',', '.'));

        $('.selected-venta').text(numberVenta.toLocaleString('de-DE'));
        $('.selected-costo').text(numberCosto.toLocaleString('de-DE'));
        $('.selected-stock').text(stock.toLocaleString('de-DE'));
      })

      // Repuestos
      $('#repuesto-procedencia').select2({
        placeholder: 'Seleccione...',
      });

      $('#repuesto-procedencia').change(function () {
        let procedencia = $(this).val();
        let isInternacional = procedencia == 'internacional';

        $('#procedencia-title').text(procedencia.charAt(0).toUpperCase() + procedencia.slice(1));

        $('.field-local').prop('disabled', !(procedencia == 'local')).closest('.form-group').toggle(procedencia == 'local');
        $('.field-nacional').prop('disabled', !(procedencia == 'nacional')).closest('.form-group').toggle(procedencia == 'nacional');
        $('.field-internacional').prop('disabled', !isInternacional).closest('.form-group').toggle(isInternacional);
        $('.group-field-internacional').toggle(isInternacional);
        $('#impuestos-internacional').prop('disabled', !isInternacional).closest('.form-group').toggle(isInternacional);
      });

      $('#repuesto-moneda').change(function () {
        let isPeso = $(this).val() == 'peso';

        $('#repuesto-moneda-valor').prop({'disabled': isPeso, 'required': !isPeso}).closest('.form-group').toggle(!isPeso);
      })
      $('#repuesto-moneda').change();

      $('#repuesto-form').on('submit', function (e) {
        e.preventDefault();

        let form = $(this),
            action = form.attr('action'),
            btn = form.find('button[type="submit"]'),
            alert = form.find('.alert');

        btn.prop('disabled', true);
        alert.hide();

        let data = form.serialize();

        let done = function (data) {
          if(data.response){
            let option = `<option value="${data.repuesto.id}"
                            data-titulo="${data.repuesto.descripcion}"
                            data-venta="${data.repuesto.venta}"
                            data-stock="${data.repuesto.stock}"
                            data-costo="${data.repuesto.costo}"
                          >${data.descripcion}</option>
                          `;
            $(`#repuesto`).append(option)
            $(`#repuesto`).val(data.repuesto.id)
            $(`#repuesto`).trigger('change')
            form[0].reset()
            $('#addRepuestoModal').modal('hide') 
          }else{
            showErrors(['Ha ocurrido un error.'])
          }
        };

        let fail = function (data) {
          showErrors(data.responseJSON.errors)
        };

        let always = function () {
          btn.prop('disabled', false)
        };

        sendRequest(action, data, done, fail);
      })

      // Filtrar repuestos
      $('#search-sistema, #search-componente, #search-anio, #search-motor, #search-insumo-formato, #search-insumo-grado, #search-insumo-marca').select2({
        placeholder: 'Seleccione...',
        allowClear: true,
      });

      $('#search-sistema, #search-componente, #search-anio, #search-motor').change(searchRepuestos);
      searchRepuestos();

      $('#search-insumo-formato, #search-insumo-grado, #search-insumo-marca').change(searchInsumo);
      searchInsumo();

      /* Sugerir precio de venta */
      $('.btn-sugerir').click(precioSugerido);
    }) // DOM Ready
  
    // Stock de los repuestos
    const ITEMS_STOCK = {
      repuesto: {},
      insumo: {},
    };
  
    // Informacion del Item que sera agregado a la hoja de situacion
    let dato = function(index, dato) {
      return `<tr id="tr-${index}" class="tr-dato" data-type="${dato.type}" data-item="${dato.item}" data-cantidad="${dato.cantidad}">
                <td>
                  <button class="btn btn-danger btn-fill btn-xs btn-delete" type="button" role="button" data-id="${index}"><i class="fa fa-trash"></i></button>
                </td>
                <td>
                  ${dato.titulo}
                  ${(dato.type == 'horas' || dato.type == 'otros') ? ('<p class="0"><small>'+dato.descripcion+'</small></p>') : ''}
                  <input type="hidden" name="datos[${index}][item]" value="${dato.item}">
                  <input type="hidden" name="datos[${index}][type]" value="${dato.type}">
                  <input type="hidden" name="datos[${index}][titulo]" value="${dato.titulo}">
                  <input type="hidden" name="datos[${index}][descripcion]" value="${dato.descripcion}">
                </td>
                <td class="text-right">
                  ${dato.costo.toLocaleString('de-DE')}
                  <input type="hidden" name="datos[${index}][costo]" value="${dato.costo}">
                </td>
                <td class="text-right">
                  ${dato.utilidad.toLocaleString('de-DE')}
                  <input type="hidden" name="datos[${index}][utilidad]" value="${dato.utilidad}">
                </td>
                <td class="text-right">
                  ${dato.descuento.text}
                  <input type="hidden" name="datos[${index}][descuento_text]" value="${dato.descuento.text}">
                  <input type="hidden" name="datos[${index}][descuento_type]" value="${dato.descuento.tipo}">
                  <input type="hidden" name="datos[${index}][descuento]" value="${dato.descuento.cantidad}">
                </td>
                <td class="text-center">
                  ${dato.cantidad}
                  <input type="hidden" name="datos[${index}][cantidad]" value="${dato.cantidad}">
                </td>
                <td class="text-right">
                  ${dato.venta.toLocaleString('de-DE')}
                  <input type="hidden" name="datos[${index}][valor_venta]" value="${dato.venta}">
                </td>
                <td class="text-right">
                  ${dato.total.toLocaleString('de-DE')}
                  <input type="hidden" name="datos[${index}][total]" value="${dato.total}">
                </td>
              </tr>`
    }

    // Eliminar elemento añadido a la hoja de situacion
    function deleteRow(){
      let id = $(this).data('id');
      let tr = $(`#tr-${id}`);
      let type = tr.data('type');
      let item = tr.data('item');
      let cantidad = tr.data('cantidad');

      if(type == 'insumo' || type == 'repuesto'){
        let option = $(`option[value="${item}"]`);
        let stock = getStock(type, option);
        let result = stock + cantidad;
        updateStock(type, option, result);
      }

      tr.remove();
      toggleBtn();
    }

    function checkStock(type, cantidad, option){
      let item = option.val();
      let stock = getStock(type, option);
      let result = stock - cantidad;

      if(result < 0){
        return true;
      }

      updateStock(type, option, result);

      return false;
    }

    function getStock(type, option){
      let item = option.val();
      let stock = +(option.data('stock') || 0 );
      stock = typeof stock == 'number' ? stock : +(stock.replace(',', '.'));

      if(ITEMS_STOCK[type].hasOwnProperty(item)){
        stock = ITEMS_STOCK[type][item];
      }else{
        ITEMS_STOCK[type][item] = stock;
      }

      return stock;
    }

    function updateStock(type, option, stock){
      let item = option.val();
      
      ITEMS_STOCK[type][item] = stock;
      option.data('stock', stock);

      if(type == 'insumo' || type == 'repuesto'){
        $(`#${type}`).change();
      }
    }

    function toggleBtn(){
      $('#btn-situacion').prop('disabled', $('.tr-dato').length <= 0)
    }

    // Mostrar errores
    function showErrors(errors, ul = '.form-errors-repuesto'){
      $(ul).empty();
      $.each(errors, function (k, v){
        if($.isArray(v)){
          $.each(v, function (k2, error){
            $(ul).append(`<li>${error}</li>`);
          })
        }else{
          $(ul).append(`<li>${v}</li>`);
        }
      })

      $(ul).parent().show().delay(7000).hide('slow');
    }

    // Buscar repuestos
    function searchRepuestos(){
      let repuestoField = $('#repuesto');
      repuestoField.prop('disabled', true);

      let sistema = $('#search-sistema').val() ? $('#search-sistema').val() : null,
          componente = $('#search-componente').val() ? $('#search-componente').val() : null,
          anio = $('#search-anio').val() ? $('#search-anio').val() : null,
          motor = $('#search-motor').val() ? $('#search-motor').val() : null;

      let data = {
            _token: '{{ csrf_token() }}',
            modelo: '{{ $situacion->proceso->vehiculo->vehiculo_modelo_id }}',
            sistema: sistema,
            componente: componente,
            anio: anio,
            motor: motor,
          };

      let done = function (repuestos) {
        repuestoField.html('<option value="">Seleccione...</option>');

        $.each(repuestos, function(k, repuesto){
          let option = `<option value="${repuesto.id}"
                          data-titulo="${repuesto.descripcion}"
                          data-venta="${repuesto.venta}"
                          data-stock="${repuesto.stock}"
                          data-costo="${repuesto.costo ?? 0}"
                        >${repuesto.anio} | ${repuesto.sistema} - ${repuesto.componente}</option>`;

          repuestoField.append(option)
        })
        repuestoField.prop('disabled', false)
      };

      let fail = function (response) {
        showErrors(response.responseJSON.errors, '.form-errors-search-items');
      };

      sendRequest('{{ route("admin.repuesto.search") }}', data, done, fail)
    }

    // Buscar repuestos
    function searchInsumo(){
      let marca = $('#search-insumo-marca').val() ? $('#search-insumo-marca').val() : null,
          grado = $('#search-insumo-grado').val() ? $('#search-insumo-grado').val() : null,
          formato = $('#search-insumo-formato').val() ? $('#search-insumo-formato').val() : null;

      let insumoField = $('#insumo');
      insumoField.prop('disabled', true);

      let data = {
            marca: marca,
            grado: grado,
            formato: formato,
          };

      let done = function (insumos) {
        insumoField.html('<option value="">Seleccione...</option>');

        $.each(insumos, function(k, insumo){
          let option = `<option value="${insumo.id}"
                data-titulo="${insumo.descripcion}"
                data-venta="${insumo.venta}"
                data-stock="${insumo.stock}"
                data-costo="${insumo.costo}">${insumo.tipo} | ${insumo.marca} | ${insumo.nombre} | ${insumo.grado} | (${insumo.formato})</option>`;

          insumoField.append(option);
        })
        insumoField.prop('disabled', false);
      };

      let fail = function (response) {
        showErrors(response.responseJSON.errors, '.form-errors-search-items');
      };

      sendRequest('{{ route("admin.insumo.search") }}', data, done, fail);
    }

    /* Sugerir precio de venta */
    function precioSugerido() {
      let moneda = $('#repuesto-moneda').val();
      let valorMoneda = moneda == 'peso' ? 1 : +$('#repuesto-moneda-valor').val();
      let cantidad = +$('#repuesto-stock').val();
      let costoRepuesto = +$('#repuesto-costo').val();

      if(moneda != 'peso' && !valorMoneda){
        showErrors(['Debe completar el valor de la moneda seleccionada'], '.form-errors-repuesto');
        return;
      }

      if(!cantidad){
        showAlert('Debe introducir una cantidad en Stock');
        return;
      }

      let type = $('#repuesto-procedencia').val();
      let fieldVenta = $('#repuesto-venta');
      let gastosGenerales = +$('#repuesto-generales').val();

      let costo = costoRepuesto * cantidad;
      let porc = costo / (costoRepuesto * cantidad);
      let costoTotal = 0;


      if(type == 'local'){
        costoTotal = costo;
      }else if(type == 'nacional'){
        let flete = +$('#repuesto-envio').val();
        let envio = flete * porc;

        costoTotal = costo + envio;
      }else{
        let impuestos = +$('#repuesto-impuestos-internacional').val();
        let flete1 = +$('#repuesto-envio1-internacional').val();
        let flete2 = +$('#repuesto-envio2-internacional').val();
        let comisionCasilla = +$('#repuesto-casilla-internacional').val();
        let envio1 = flete1 * porc;
        let envio2 = flete2 * porc;
        let costoEnvioTotal = costo + envio1 + envio2;

        let impuestoTotal = impuestos * costoEnvioTotal;
        costoTotal = impuestoTotal + ((comisionCasilla * porc) / valorMoneda);
      }

      let gastosGeneralesTotal = costoTotal * gastosGenerales;
      let sugerido = ((gastosGeneralesTotal * valorMoneda) / cantidad);

      fieldVenta.val(sugerido.toFixed(2));
    }

    // Relizar peticiones por ajax
    function sendRequest(action, data, done, fail, always = null, type = 'POST'){
      $.ajax({
        type: type,
        url: action,
        data: data,
        cache: false,
        dataType: 'json',
      })
      .done(done)
      .fail(fail)
      .always(always)
    }
  </script>
@endsection
