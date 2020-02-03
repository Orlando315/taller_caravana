@extends('layouts.app')

@section('title', 'Repuestos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.repuesto.index') }}"> Repuestos </a>
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
        <a class="btn btn-default" href="{{ route('admin.repuesto.index') }}"><i class="fa fa-reply" aria-hidden="true"></i> Volver</a>

      @if(Auth::user()->role != 'user')
        <a class="btn btn-success" href="{{ route('admin.repuesto.edit', ['repuesto' => $repuesto->id]) }}"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
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
                        <th>Nro. parte:</th>
                        <td>{{ $repuesto->nro_parte }}</td>
                      </tr>
                      <tr>
                        <th>Nro. OEM:</th>
                        <td>{{ $repuesto->nro_oem }}</td>
                      </tr>
                      <tr>
                        <th>Marca OEM:</th>
                        <td>{{ $repuesto->marca_oem }}</td>
                      </tr>
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
                        <td>{{ $repuesto->motor }}</td>
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
                        <th>Procedencia:</th>
                        <td>{{ $repuesto->procedencia() }}</td>
                      </tr>
                      @if($repuesto->procedencia == 'nacional' || $repuesto->procedencia == 'internacional')
                      <tr>
                        <th>Envio:</th>
                        <td>{{ $repuesto->envio }}</td>
                      </tr>
                      @endif
                      @if($repuesto->procedencia == 'internacional')
                      <tr>
                        <th>Aduana:</th>
                        <td>{{ $repuesto->aduana }}</td>
                      </tr>
                      @endif
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
                        <th>Costo:</th>
                        <td>{{ $repuesto->extra->costo() ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <th>Envio 1:</th>
                        <td>{{ $repuesto->extra->envio1() ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <th>Envio 2:</th>
                        <td>{{ $repuesto->extra->envio2() ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <th>Gastos casilla:</th>
                        <td>{{ $repuesto->extra->casilla() ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <th>Impuestos:</th>
                        <td>{{ $repuesto->extra->impuestos() ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <th>Gastos generales:</th>
                        <td>{{ $repuesto->extra->generales() ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <th>Costo tramitación:</th>
                        <td>{{ $repuesto->extra->tramitacion() ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <th>Moneda:</th>
                        <td>{{ $repuesto->extra->moneda() ?? 'N/A' }}</td>
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

  @if(Auth::user()->role != 'user')
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
