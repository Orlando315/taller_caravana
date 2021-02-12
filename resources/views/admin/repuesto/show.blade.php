@extends('layouts.app')

@section('title', 'Repuestos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.repuesto.index') }}"> Repuestos </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <a class="btn btn-default" href="{{ route('admin.repuesto.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>

      @if(Auth::user()->isAdmin())
        <a class="btn btn-success" href="{{ route('admin.repuesto.edit', ['repuesto' => $repuesto->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
        <a class="btn btn-default" href="{{ route('admin.repuesto.create', ['clone' => $repuesto->id]) }}"><i class="fa fa-clone" aria-hidden="true"></i> Clonar</a>
        <button class="btn btn-fill btn-danger" data-toggle="modal" data-target="#delModal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
      @endif
    </div>
  </div>
  
  @include('partials.flash')

  <div class="row mt-2">
    <div class="col-12">
      <div class="card card-information">
        <div class="card-body">
          <div class="row">
            <div class="col-md-3 text-center">
              <figure class="figure w-100 m-0">
                <img src="{{ $repuesto->getPhoto() }}" class="figure-img img-thumbnail img-fluid m-0" alt="{{ $repuesto->nombre }}" style="max-height: 150px;">
              </figure>
            </div>
            <div class="col-md-9">
              <div class="row">
                <div class="col-12">
                  <h4 class="m-0">
                    Stock
                  </h4>
                  @if(Auth::user()->isAdmin())
                    <button class="btn btn-xs btn-simple btn-info" type="buttom" data-toggle="modal" data-target="#addStockModal" data-type="1">Agregar</button>
                    |
                    <button class="btn btn-xs btn-simple btn-info" type="buttom" data-toggle="modal" data-target="#addStockModal" data-type="0">Actualizar</button>
                  @endif
                  <p class="m-0">
                    Stock: {{ $repuesto->stock }}
                  </p>
                  <hr class="mb-0 mb-2">
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <h4 class="m-0">Repuesto</h4>
                  <table class="table table-striped table-sm">
                    <tbody>
                      <tr>
                        <th>Marca:</th>
                        <td>{{ $repuesto->marca->marca }}</td>
                      </tr>
                      <tr>
                        <th>Modelo:</th>
                        <td>{{ $repuesto->modelo->modelo }}</td>
                      </tr>
                      <tr>
                        <th>Año:</th>
                        <td>{{ $repuesto->anio() ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <th>Motor:</th>
                        <td>{{ $repuesto->motor() }}</td>
                      </tr>
                      <tr>
                        <th>Sistema:</th>
                        <td>{{ $repuesto->sistema ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <th>Componente:</th>
                        <td>{{ $repuesto->componente }}</td>
                      </tr>
                      <tr>
                        <th>N° parte:</th>
                        <td>{{ $repuesto->nro_parte ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <th>N° OEM:</th>
                        <td>{{ $repuesto->nro_oem ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <th>Marca OEM:</th>
                        <td>{{ $repuesto->marca_oem ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <th>Procedencia:</th>
                        <td>{{ $repuesto->procedencia() }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-md-6">
                  <h4 class="m-0">
                    Extras
                  </h4>
                  <table class="table table-striped table-sm">
                    <tbody>
                      <tr>
                        <th>Moneda:</th>
                        <td class="text-right">
                          {{ $repuesto->extra->moneda() }}{!! $repuesto->extra->moneda_valor ? ' <small>('.$repuesto->extra->monedaValor().')</small>' : '' !!}
                        </td>
                      </tr>
                      <tr>
                        <th>Costo:</th>
                        <td class="text-right">
                          {{ $repuesto->extra->costo($repuesto->isNotPesos()) ?? 'N/A' }}{!! ($repuesto->isNotPesos() && $repuesto->extra->costo) ? ' <small>('.$repuesto->extra->costo().')</small>' : '' !!}
                        </td>
                      </tr>
                      @if($repuesto->isNacional())
                      <tr>
                        <th>Envio:</th>
                        <td class="text-right">
                            {{ $repuesto->envio($repuesto->isNotPesos()) ?? 'N/A' }}{!! ($repuesto->isNotPesos() && $repuesto->envio) ? ' <small>('.$repuesto->envio().')</small>' : '' !!}
                        </td>
                      </tr>
                      @endif
                      @if($repuesto->isInternacional())
                        <tr>
                          <th>Envio 1:</th>
                          <td class="text-right">
                            {{ $repuesto->extra->envio1($repuesto->isNotPesos()) ?? 'N/A' }}{!! ($repuesto->isNotPesos() && $repuesto->extra->envio1) ? ' <small>('.$repuesto->extra->envio1().')</small>' : '' !!}
                          </td>
                        </tr>
                        <tr>
                          <th>Envio 2:</th>
                          <td class="text-right">
                            {{ $repuesto->extra->envio2($repuesto->isNotPesos()) ?? 'N/A' }}{!! ($repuesto->isNotPesos() && $repuesto->extra->envio2) ? ' <small>('.$repuesto->extra->envio2().')</small>' : '' !!}
                          </td>
                        </tr>
                        <tr>
                          <th>Gastos casilla:</th>
                          <td class="text-right">{{ $repuesto->extra->casilla() ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                          <th>Impuestos{!! $repuesto->isInternacional() ? ' <small>'.$repuesto->extra->impuestosTipo().'</small>' : '' !!}:</th>
                          <td class="text-right">{{ $repuesto->extra->impuestos($repuesto->isNotPesos()) ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                          <th>Costo tramitación:</th>
                          <td class="text-right">{{ $repuesto->extra->tramitacion() ?? 'N/A' }}</td>
                        </tr>
                      @endif
                      <tr>
                        <th>Gastos generales{!! $repuesto->isInternacional() ? ' <small>('.$repuesto->extra->generales().'%)</small>' : '' !!}:</th>
                        <td class="text-right">{{ $repuesto->isInternacional() ? ($repuesto->extra->generalesTotal() ?? 'N/A') : ($repuesto->extra->generales() ?? 'N/A') }}</td>
                      </tr>
                      <tr>
                        <th>Costo total:</th>
                        <td class="text-right">{{ $repuesto->extra->costoTotal() }}</td>
                      </tr>
                      <tr>
                        <th>Venta:</th>
                        <td class="text-right">{{ $repuesto->venta() }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              @if($repuesto->hasComentarios())
                <hr class="mt-0 mb-2">
                <p><strong>Comentarios:</strong> {{ $repuesto->comentarios }}</p>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if(Auth::user()->isAdmin())
    <div id="delModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="delModalLabel">Eliminar Repuesto</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row justify-content-md-center">
              <form class="col-md-10" action="{{ route('admin.repuesto.destroy', ['repuesto' => $repuesto->id]) }}" method="POST">
                @csrf
                @method('DELETE')

                <p class="text-center">¿Esta seguro de eliminar este Repuesto?</p><br>

                <center>
                  <button class="btn btn-fill btn-danger" type="submit">Eliminar</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </center>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="addStockModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addStockModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="addStockModalLabel">Agregar Stock</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row justify-content-md-center">
              <form class="col-md-10" action="{{ route('admin.repuesto.stock', ['repuesto' => $repuesto->id]) }}" method="POST">
                <input id="stock-type" type="hidden" name="type" value="1">
                @csrf
                @method('PATCH')
                <p id="stock-message" class="text-center"></p>

                <div class="form-group">
                  <label class="control-label" for="stock">Stock: *</label>
                  <input id="stock" class="form-control{{ $errors->has('stock') ? ' is-invalid' : '' }}" type="number" name="stock" min="0" max="9999" value="{{ old('stock') }}" placeholder="Stock" required>
                </div>

                <center>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button class="btn btn-fill btn-primary" type="submit">Guardar</button>
                </center>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function () {
      $('#addStockModal').on('show.bs.modal', function (e) {
        let type = $(e.relatedTarget).data('type');

        $('#stock-message').text(type == '1' ? 'El Stock se sumará al disponible actualmente' : 'El Stock reemplazará el disponible actualmente');
        $('#addStockModalLabel').text(type == '1' ? 'Agregar Stock' : 'Actualizar Stock');
        $('#stock-type').val(type);
      })
    })
  </script>
@endsection
