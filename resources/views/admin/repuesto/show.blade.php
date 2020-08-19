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
                        <td>{{ $repuesto->anio() }}</td>
                      </tr>
                      <tr>
                        <th>Motor:</th>
                        <td>{{ $repuesto->motor() }}</td>
                      </tr>
                      <tr>
                        <th>Sistema:</th>
                        <td>{{ $repuesto->sistema }}</td>
                      </tr>
                      <tr>
                        <th>Componente:</th>
                        <td>{{ $repuesto->componente }}</td>
                      </tr>
                      <tr>
                        <th>N° parte:</th>
                        <td>{{ $repuesto->nro_parte }}</td>
                      </tr>
                      <tr>
                        <th>N° OEM:</th>
                        <td>{{ $repuesto->nro_oem }}</td>
                      </tr>
                      <tr>
                        <th>Marca OEM:</th>
                        <td>{{ $repuesto->marca_oem }}</td>
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
                        <td>{{ $repuesto->extra->moneda() }}</td>
                      </tr>
                      <tr>
                        <th>Costo:</th>
                        <td class="text-right">{{ $repuesto->extra->costo() ?? 'N/A' }}</td>
                      </tr>
                      @if($repuesto->isNacional())
                      <tr>
                        <th>Envio:</th>
                        <td class="text-right">{{ $repuesto->envio() }}</td>
                      </tr>
                      @endif
                      @if($repuesto->isInternacional())
                        <tr>
                          <th>Envio 1:</th>
                          <td class="text-right">{{ $repuesto->extra->envio1() ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                          <th>Envio 2:</th>
                          <td class="text-right">{{ $repuesto->extra->envio2() ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                          <th>Gastos casilla:</th>
                          <td class="text-right">{{ $repuesto->extra->casilla() ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                          <th>Impuestos{!! $repuesto->isInternacional() ? ' <small>('.$repuesto->extra->impuestosTipo().')</small>' : '' !!}:</th>
                          <td class="text-right">{{ $repuesto->extra->impuestos() ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                          <th>Costo tramitación:</th>
                          <td class="text-right">{{ $repuesto->extra->tramitacion() ?? 'N/A' }}</td>
                        </tr>
                      @endif
                      <tr>
                        <th>Gastos generales{!! $repuesto->isInternacional() ? ' <small>('.$repuesto->extra->generales().'%)</small>' : '' !!}:</th>
                        <td class="text-right">{{ $repuesto->isInternacional() ? $repuesto->extra->generalesTotal() : $repuesto->extra->generales() }}</td>
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
  @endif
@endsection
