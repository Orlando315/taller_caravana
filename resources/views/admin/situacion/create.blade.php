@extends('layouts.app')

@section('title', 'Situación - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proceso.show', ['proceso' => $proceso->id]) }}"> Situación </a>
@endsection

@section('content')
  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-body">
          <h4>Generar Hoja de situación</h4>
          
          <h5 class="text-center">{{ $proceso->cliente->nombre().' | '.$proceso->vehiculo->vehiculo() }}</h5>
          
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
                  <label class="control-label" for="search-marca">Marca: *</label>
                  <select id="search-marca" class="form-control" style="width: 100%">
                    <option value="">Seleccione...</option>
                    @foreach($marcas as $marca)
                      <option value="{{ $marca->id }}"{{ $proceso->vehiculo->vehiculo_marca_id == $marca->id ? ' selected' : '' }}>{{ $marca->marca }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="control-label" for="search-modelo">Modelo: *</label>
                  <select id="search-modelo" class="form-control" disabled style="width: 100%">
                    <option value="">Seleccione...</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-5">
                <div class="form-group set-insumo">
                  <label for="insumo">Insumo:</label>
                  <select id="insumo" class="form-control" name="">
                    <option value="">Seleccione...</option>
                    @foreach($insumos as $insumo)
                      <option value="{{ $insumo->id }}"
                        data-titulo="{{ $insumo->descripcion() }}"
                        data-venta="{{ $insumo->stockEnUso->venta }}"
                        data-stock="{{ $insumo->getStock() }}"
                        data-costo="{{ $insumo->stockEnUso->coste }}">{{ $insumo->tipo->tipo }} | {{ $insumo->marca }} | {{ $insumo->nombre }} | {{ $insumo->grado }} | ({{ $insumo->formato->formato }})</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group set-repuesto" style="display: none;">
                  <label for="repuesto">Repuesto:</label>
                  <select id="repuesto" class="form-control" style="width: 100%">
                    <option value="">Seleccione...</option>
                    @foreach($repuestos as $repuesto)
                      <option value="{{ $repuesto->id }}"
                        data-titulo="{{ $repuesto->descripcion() }}"
                        data-venta="{{ $repuesto->venta }}"
                        data-stock="{{ $repuesto->stock }}"
                        data-costo="{{ $repuesto->extra->costo_total }}">{{ $repuesto->descripcion() }}</option>
                    @endforeach
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
                  <input id="cantidad" class="form-control" type="number" min="1" max="9999" required>
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
              <ul class="m-0 form-errors-search-repuesto">
              </ul>
            </div>

            <center>
              <button class="btn btn-primary btn-fill btn-sm" type="submit"><i class="fa fa-plus"></i> Agregar item</button>
            </center>
          </form><!-- form -->
          
          <hr>

          <form action="{{ route('admin.situacion.store', ['proceso' => $proceso->id]) }}" method="POST">
            @csrf
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
              <ul clasS="m-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif

            <div class="form-group text-right">
              <a class="btn btn-default" href="{{ route('admin.proceso.show', ['proceso' => $proceso->id]) }}"><i class="fa fa-reply"></i> Atras</a>
              <button id="btn-cotizacion" class="btn btn-primary" type="submit" disabled><i class="fa fa-send"></i> Guardar</button>
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
          <form id="repuesto-form" action="{{ route('admin.repuesto.store') }}" method="POST">
            <input id="cliente-vehiculo" type="hidden" name="cliente">
            @csrf
          
            <fieldset>
              <legend>Datos del Repuesto</legend>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="marca">Marca: *</label>
                    <select id="marca" class="form-control" name="marca" required style="width: 100%">
                      <option value="">Seleccione...</option>
                      @foreach($marcas as $marca)
                        <option value="{{ $marca->id }}"{{ $proceso->vehiculo->vehiculo_marca_id == $marca->id ? ' selected' : '' }}>{{ $marca->marca }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="modelo">Modelo: *</label>
                    <select id="modelo" class="form-control" name="modelo" required disabled style="width: 100%">  
                      <option value="">Seleccione...</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="año">Año: *</label>
                    <input id="año" class="form-control{{ $errors->has('año') ? ' is-invalid' : '' }}" type="number" name="año" min="0" step="1" max="9999" value="{{ old('año') }}" placeholder="Año" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="motor">Motor (cc): *</label>
                    <input id="motor" class="form-control{{ $errors->has('motor') ? ' is-invalid' : '' }}" type="number" min="0" max="9999" name="motor" value="{{ old('motor') }}" placeholder="Motor" required>
                    <small class="text-muted">Solo números</small>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="sistema">Sistema: *</label>
                    <input id="sistema" class="form-control{{ $errors->has('sistema') ? ' is-invalid' : '' }}" type="text" name="sistema" maxlength="50" value="{{ old('sistema') }}" placeholder="Sistema" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="componente">Componente: *</label>
                    <input id="componente" class="form-control{{ $errors->has('componente') ? ' is-invalid' : '' }}" type="text" name="componente" maxlength="50" value="{{ old('componente') }}" placeholder="Componente" required>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="nro_parte">N° parte:</label>
                    <input id="nro_parte" class="form-control{{ $errors->has('nro_parte') ? ' is-invalid' : '' }}" type="text" name="nro_parte" maxlength="50" value="{{ old('nro_parte') }}" placeholder="N° parte">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="nro_oem">N° OEM:</label>
                    <input id="nro_oem" class="form-control{{ $errors->has('nro_oem') ? ' is-invalid' : '' }}" type="text" name="nro_oem" maxlength="50" value="{{ old('nro_oem') }}" placeholder="N° OEM">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="marca_oem">Marca OEM: *</label>
                    <input id="marca_oem" class="form-control{{ $errors->has('marca_oem') ? ' is-invalid' : '' }}" type="text" name="marca_oem" maxlength="50" value="{{ old('marca_oem') }}" placeholder="Marca OEM" required>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="procedencia">Procedencia: *</label>
                    <select id="procedencia" class="form-control" name="procedencia" required style="width: 100%">
                      <option>Seleccione...</option>
                      <option value="local" {{ old('procedencia') == 'local' ? 'selected' : '' }}>Local</option>
                      <option value="nacional" {{ old('procedencia') == 'nacional' ? 'selected' : '' }}>Nacional</option>
                      <option value="internacional" {{ old('procedencia') == 'internacional' ? 'selected' : '' }}>Internacional</option>
                    </select>
                  </div>
                </div>
              </div>
            </fieldset>

            <fieldset id="field-local" style="display: none">
              <legend>Local</legend>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="moneda-local">Moneda: *</label>
                    <select id="moneda-local" class="custom-select" name="moneda" required style="width: 100%">
                      <option value="">Seleccione...</option>
                      <option value="peso" {{ old('moneda', 'peso') == 'peso' ? 'selected' : '' }}>Peso chileno</option>
                      <option value="dolar" {{ old('moneda', 'peso') == 'dolar' ? 'selected' : '' }}>Dólar</option>
                      <option value="euro" {{ old('moneda', 'peso') == 'euro' ? 'selected' : '' }}>Euro</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="costo">Costo:</label>
                    <input id="costo" class="form-control{{ $errors->has('costo') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="costo" maxlength="50" value="{{ old('costo') }}" placeholder="Costo">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="generales">Gastos generales:</label>
                    <input id="generales" class="form-control{{ $errors->has('generales') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="generales" maxlength="50" value="{{ old('generales') }}" placeholder="Gastos generales">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="venta">Precio de venta: *</label>
                    <input id="venta" class="form-control{{ $errors->has('venta') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="venta" maxlength="50" value="{{ old('venta') }}" placeholder="Venta" required>
                  </div>
                </div>
              </div>
            </fieldset>

            <fieldset id="field-nacional" style="display: none">
              <legend>Nacional</legend>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="moneda-nacional">Moneda: *</label>
                    <select id="moneda-nacional" class="custom-select" name="moneda" required>
                      <option value="">Seleccione...</option>
                      <option value="peso" {{ old('moneda', 'peso') == 'peso' ? 'selected' : '' }}>Peso chileno</option>
                      <option value="dolar" {{ old('moneda', 'peso') == 'dolar' ? 'selected' : '' }}>Dólar</option>
                      <option value="euro" {{ old('moneda', 'peso') == 'euro' ? 'selected' : '' }}>Euro</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="costo">Costo:</label>
                    <input id="costo" class="form-control{{ $errors->has('costo') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="costo" value="{{ old('costo') }}" placeholder="Costo">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="generales">Gastos generales:</label>
                    <input id="generales" class="form-control{{ $errors->has('generales') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="generales" value="{{ old('generales') }}" placeholder="Gastos generales">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="envio">Envio:</label>
                    <input id="envio" class="form-control{{ $errors->has('envio') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="envio" value="{{ old('envio') }}" placeholder="Envio">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="venta">Precio de venta: *</label>
                    <input id="venta" class="form-control{{ $errors->has('venta') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="venta" value="{{ old('venta') }}" placeholder="Venta" required>
                  </div>
                </div>
              </div>
            </fieldset>

            <fieldset id="field-internacional" style="display: none">
              <legend>Internacional</legend>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="moneda-internacional">Moneda: *</label>
                    <select id="moneda-internacional" class="custom-select" name="moneda" required style="width: 100%">
                      <option value="">Seleccione...</option>
                      <option value="peso" {{ old('moneda', 'dolar') == 'peso' ? 'selected' : '' }}>Peso chileno</option>
                      <option value="dolar" {{ old('moneda', 'dolar') == 'dolar' ? 'selected' : '' }}>Dólar</option>
                      <option value="euro" {{ old('moneda', 'dolar') == 'euro' ? 'selected' : '' }}>Euro</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="costo">Costo:</label>
                    <input id="costo" class="form-control{{ $errors->has('costo') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="costo" value="{{ old('costo') }}" placeholder="Costo">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="envio1">Envio 1:</label>
                    <input id="envio1" class="form-control{{ $errors->has('envio1') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="envio1" value="{{ old('envio1') }}" placeholder="Envio 1">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="envio2">Envio 2:</label>
                    <input id="envio2" class="form-control{{ $errors->has('envio2') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="envio2" value="{{ old('envio2') }}" placeholder="Envio 2">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="casilla">Gastos casilla:</label>
                    <input id="casilla" class="form-control{{ $errors->has('casilla') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="casilla" value="{{ old('casilla') }}" placeholder="Gastos casilla">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label">Impuestos:</label>
                    <div class="custom-control custom-radio">
                      <input type="radio" id="impuestos-25" name="impuestos" class="custom-control-input" value="25">
                      <label class="custom-control-label" for="impuestos-25">25% del FOB</label>
                    </div>
                    <div class="custom-control custom-radio">
                      <input type="radio" id="impuestos-19" name="impuestos" class="custom-control-input" value="19">
                      <label class="custom-control-label" for="impuestos-19">19% del FOB</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="gasto-general-internacional">Gastos generales:</label>
                    <select id="gasto-general-internacional" class="custom-select" name="generales">
                      <option value="">Seleccione...</option>
                      <option value="0" {{ old('generales') == '0' ? 'selected' : '' }}>0%</option>
                      <option value="15" {{ old('generales') == '15' ? 'selected' : '' }}>15%</option>
                      <option value="20" {{ old('generales') == '20' ? 'selected' : '' }}>20%</option>
                      <option value="25" {{ old('generales') == '25' ? 'selected' : '' }}>25%</option>
                      <option value="30" {{ old('generales') == '30' ? 'selected' : '' }}>30%</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="tramitacion">Costo tramitación:</label>
                    <input id="tramitacion" class="form-control{{ $errors->has('tramitacion') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="tramitacion" maxlength="50" value="{{ old('tramitacion') }}" placeholder="Costo tramitación">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="control-label" for="venta">Precio de venta: *</label>
                    <input id="venta" class="form-control{{ $errors->has('venta') ? ' is-invalid' : '' }}" type="number" step="0.01" min="0" max="99999999" name="venta" value="{{ old('venta') }}" placeholder="Venta" required>
                  </div>
                </div>
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

        $('.selected-venta,.selected-costo,.selected-stock').text('-');
      })

      $('#tipo').change()

      $('#form-load-item').submit(function (e) {
        e.preventDefault()

        $('#btn-cotizacion').prop('disabled', false)

        let tipo = $('#tipo').val();
        let useSelect  = (tipo == 'insumo' || tipo == 'repuesto')

        // Solo cuando es Insumo o Repuesto
        let value = useSelect ? $(`#${tipo}`).val() : null
        let option = useSelect ? $(`#${tipo} option[value="${value}"]`) : null

        let cantidad = $('#cantidad').val();
        let venta = (useSelect && $(option).data('venta')) ? $(option).data('venta') : +$('#venta').val();
        venta = typeof venta == 'number' ? venta : +(venta.replace(',', '.'));

        if(useSelect && checkStock(tipo, cantidad, option)){
          showErrors(['La cantidad ingresada supera el stock disponible actualmente'], '.form-errors-search-repuesto');
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

        $('#cantidad, #descuento, #venta, #descripcion').val('')
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
      $('#marca, #modelo, #procedencia').select2({
        placeholder: 'Seleccione...',
      });

      // Buscar modelos por Marca
      $('#marca').on('change',function () {
        let marca = $(this).val()

        if(!marca){ return false }

        searchModelos(marca, '#modelo', '.form-errors-repuesto');
      })

      $('#marca').change()

      $('#procedencia').change(function () {
        let procedencia = $(this).val()

        $('#field-local').toggle(procedencia == 'local').prop('disabled', !(procedencia == 'local'))
        $('#field-nacional').toggle(procedencia == 'nacional').prop('disabled', !(procedencia == 'nacional'))
        $('#field-internacional').toggle(procedencia == 'internacional').prop('disabled', !(procedencia == 'internacional'))
      })

      $('#procedencia').change()

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
                          >${data.repuesto.descripcion}</option>
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
      $('#search-marca, #search-modelo').select2({
        placeholder: 'Seleccione...',
        allowClear: true,
      });

      $('#search-marca').on('change',function () {
        let marca = $(this).val()

        // Buscar Modelos de la Marca
        if(marca){
          searchModelos(marca, '#search-modelo', '.form-errors-search-repuesto');
        }else{
          $('#search-modelo').empty()
          $('#search-modelo').prop('disabled', true)
        }

        // Buscar repuestos
        searchRepuestos(marca ? marca : null)
      })

      $('#search-marca').change()

      $('#search-modelo').on('change',function () {
        let marca = $('#search-marca').val(),
            modelo = $(this).val();

        // Buscar repuestos
        searchRepuestos((marca ? marca : null), (modelo ? modelo : null))
      })// Filtrar repuestos
    }) // DOM Ready
  
    // Stock de los repuestos
    const ITEMS_STOCK = {
      repuesto: {},
      insumo: {},
    };

    // Informacion del Item que sera agregado a la hija de situacion
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
      $('#btn-cotizacion').prop('disabled', $('.tr-dato').length <= 0)
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

    // Buscar los Modelos por la marca especificada
    function searchModelos(marca, field, list)
    {
      let data = {
        '_token': '{{ csrf_token() }}'
      };

      let done = function (modelos) {
        $(field).html('<option value="">Seleccione...</option>');
        $.each(modelos, function(k, modelo){
          let found = modelo.id == @json($proceso->vehiculo->vehiculo_modelo_id);
          let selected = found ? 'selected' : '';
          $(field).append(`<option value="${modelo.id}" ${selected}>${modelo.modelo}</option>`);

          if(found){
            $(field).change()
          }
        })

        $(field).prop('disabled', false)
      };

      let fail = function (response) {
        $(field).prop('disabled', true)
        showErrors(response.responseJSON.errors, list)
      };

      sendRequest(`{{ route("vehiculo.marca.modelos") }}/${marca}/modelos`, data, done, fail);
    }

    // Buscar repuestos
    function searchRepuestos(marca = null, modelo = null){
      let repuestoField = $('#repuesto');
      repuestoField.prop('disabled', true)

      let data = {
            '_token': '{{ csrf_token() }}',
            'marca': marca,
            'modelo': modelo,
          };

      let done = function (repuestos) {
        repuestoField.html('<option value="">Seleccione...</option>');

        $.each(repuestos, function(k, repuesto){
          let option = `<option value="${repuesto.id}"
                          data-titulo="${repuesto.descripcion}"
                          data-venta="${repuesto.venta}"
                          data-stock="${repuesto.stock}"
                          data-costo="${repuesto.costo ?? 0}"
                        >${repuesto.descripcion}</option>`;

          repuestoField.append(option)
        })
        repuestoField.prop('disabled', false)
      };

      let fail = function (response) {
        showErrors(response.responseJSON.errors, '.form-errors-search-repuesto')
      };

      sendRequest('{{ route("admin.repuesto.search") }}', data, done, fail)
    }

    // Relizar peticiones por ajax
    function sendRequest(action, data, done, fail, always = null){
      $.ajax({
        type: 'POST',
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
