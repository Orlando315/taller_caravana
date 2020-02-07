@extends('layouts.app')

@section('title', 'Pre-evaluación - '.config('app.name'))

@section('head')
  <!-- fileinput -->
  <link rel="stylesheet" type="text/css" href="{{ asset('js/plugins/fileinput/fileinput.min.css')}}">
@endsection

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proceso.show', ['proceso' => $proceso->id]) }}"> Pre-evaluación </a>
@endsection

@section('content')
  <div class="container">

    @include('partials.flash')

    <div class="row justify-content-center">
      <div class="col-md-10">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('admin.preevaluacion.store', ['proceso' => $proceso->id]) }}" method="POST" enctype="multipart/form-data">
              @csrf
              <h4>Generar Pre-evaluación</h4>
              
              <h5 class="text-center">{{ $proceso->cliente->nombre().' | '.$proceso->vehiculo->vehiculo() }}</h5>

              <div id="foto-group" class="form-group">
                <label for="fotos">Fotos:</label>
                <div class="file-loading">
                  <input id="fotos" type="file" name="fotos[]" data-msg-placeholder="Seleccionar..." accept="image/jpeg,image/png" multiple>
                </div>
                <small class="text-muted">Hasta 6 fotos de 12 MB c/u</small>
              </div>

              <div class="table-responsive">
                <table class="table table-striped table-sm">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th class="text-center">Descripción</th>
                      <th class="text-center">Observación</th>
                      <th class="text-center">Referencia</th>
                    </tr>
                  </thead>
                  <tbody id="tbody">
                    <tr class="tr-dato">
                      <td class="text-center">1</td>
                      <td>
                        <input class="form-control{{ $errors->has('datos.1.descripcion') ? ' is-invalid' : '' }}" type="text" name="datos[1][descripcion]" maxlength="100" value="{{ old('datos.1.descripcion') }}" required>
                      </td>
                      <td>
                        <input class="form-control{{ $errors->has('datos.1.observacion') ? ' is-invalid' : '' }}" type="text" name="datos[1][observacion]" maxlength="100" value="{{ old('datos.1.observacion') }}">
                      </td>
                      <td>
                        <input class="form-control{{ $errors->has('datos.1.referencia') ? ' is-invalid' : '' }}" type="number" min="1" step="0.01" step="99999999" name="datos[1][referencia]" value="{{ old('datos.1.referencia') }}">
                      </td>
                    </tr>
                    <tr class="tr-dato">
                      <td class="text-center">2</td>
                      <td>
                        <input class="form-control{{ $errors->has('datos.2.descripcion') ? ' is-invalid' : '' }}" type="text" name="datos[2][descripcion]" maxlength="100" value="{{ old('datos.2.descripcion') }}">
                      </td>
                      <td>
                        <input class="form-control{{ $errors->has('datos.2.observacion') ? ' is-invalid' : '' }}" type="text" name="datos[2][observacion]" maxlength="100" value="{{ old('datos.2.observacion') }}">
                      </td>
                      <td>
                        <input class="form-control{{ $errors->has('datos.2.referencia') ? ' is-invalid' : '' }}" type="number" min="1" step="0.01" step="99999999" name="datos[2][referencia]" value="{{ old('datos.2.referencia') }}">
                      </td>
                    </tr>
                    <tr class="tr-dato">
                      <td class="text-center">3</td>
                      <td>
                        <input class="form-control{{ $errors->has('datos.3.descripcion') ? ' is-invalid' : '' }}" type="text" name="datos[3][descripcion]" maxlength="100" value="{{ old('datos.3.descripcion') }}">
                      </td>
                      <td>
                        <input class="form-control{{ $errors->has('datos.3.observacion') ? ' is-invalid' : '' }}" type="text" name="datos[3][observacion]" maxlength="100" value="{{ old('datos.3.observacion') }}">
                      </td>
                      <td>
                        <input class="form-control{{ $errors->has('datos.3.referencia') ? ' is-invalid' : '' }}" type="number" min="1" step="0.01" step="99999999" name="datos[3][referencia]" value="{{ old('datos.3.referencia') }}">
                      </td>
                    </tr>
                    <tr class="tr-dato">
                      <td class="text-center">4</td>
                      <td>
                        <input class="form-control{{ $errors->has('datos.4.descripcion') ? ' is-invalid' : '' }}" type="text" name="datos[4][descripcion]" maxlength="100" value="{{ old('datos.4.descripcion') }}">
                      </td>
                      <td>
                        <input class="form-control{{ $errors->has('datos.4.observacion') ? ' is-invalid' : '' }}" type="text" name="datos[4][observacion]" maxlength="100" value="{{ old('datos.4.observacion') }}">
                      </td>
                      <td>
                        <input class="form-control{{ $errors->has('datos.4.referencia') ? ' is-invalid' : '' }}" type="number" min="1" step="0.01" step="99999999" name="datos[4][referencia]" value="{{ old('datos.4.referencia') }}">
                      </td>
                    </tr>
                    <tr class="tr-dato">
                      <td class="text-center">5</td>
                      <td>
                        <input class="form-control{{ $errors->has('datos.5.descripcion') ? ' is-invalid' : '' }}" type="text" name="datos[5][descripcion]" maxlength="100" value="{{ old('datos.5.descripcion') }}">
                      </td>
                      <td>
                        <input class="form-control{{ $errors->has('datos.5.observacion') ? ' is-invalid' : '' }}" type="text" name="datos[5][observacion]" maxlength="100" value="{{ old('datos.5.observacion') }}">
                      </td>
                      <td>
                        <input class="form-control{{ $errors->has('datos.5.referencia') ? ' is-invalid' : '' }}" type="number" min="1" step="0.01" step="99999999" name="datos[5][referencia]" value="{{ old('datos.5.referencia') }}">
                      </td>
                    </tr>
                    
                    @if(old('datos'))
                      @foreach(old('datos') as $dato)
                        @continue($loop->iteration < 5)
                        <tr class="tr-dato">
                          <td class="text-center">{{ $loop->iteration }}</td>
                          <td>
                            <input class="form-control{{ $errors->has('datos.'.$loop->iteration.'.descripcion') ? ' is-invalid' : '' }}" type="text" name="datos[{{$loop->iteration}}][descripcion]" maxlength="100" value="{{ old('datos.'.$loop->iteration.'.descripcion') }}">
                          </td>
                          <td>
                            <input class="form-control{{ $errors->has('datos.'.$loop->iteration.'.observacion') ? ' is-invalid' : '' }}" type="text" name="datos[{{$loop->iteration}}][observacion]" maxlength="100" value="{{ old('datos.'.$loop->iteration.'.observacion') }}">
                          </td>
                          <td>
                            <input class="form-control{{ $errors->has('datos.'.$loop->iteration.'.referencia') ? ' is-invalid' : '' }}" type="number" min="1" step="0.01" step="99999999" name="datos[{{$loop->iteration}}][referencia]" value="{{ old('datos.'.$loop->iteration.'.referencia') }}">
                          </td>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
                  <tfoot>
                    <tr class="text-center">
                      <td colspan="4">
                        <button class="btn btn-primary btn-sm btn-new-dato" type="button" role="button" disabled><i class="fa fa-plus"></i> Agregar dato</button>
                      </td>
                    </tr>
                  </tfoot>
                </table>
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
                <a class="btn btn-default" href="{{ route('admin.proceso.show', ['proceso' => $proceso->id]) }}"><i class="fa fa-reply"></i> Atras</a>
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
  <!-- fileinput -->
  <script type="text/javascript" src="{{asset('js/plugins/fileinput/fileinput.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/plugins/fileinput/locales/es.js')}}"></script>

  <script type="text/javascript">
    $(document).ready(function () {
      btn.click(addDato)
      toggleBtn()

      $('#fotos').fileinput({
        overwriteInitial: false,
        showUpload: false,
        maxFileSize: 12000,
        initialPreviewCount: 6,
        maxFileCount: 6,
        validateInitialCount: true,
        dropZoneEnabled: false,
        browseClass: 'btn btn-success',
        browseLabel: 'Seleccionar',
        browseIcon: '<i class="fa fa-image"></i>',
        allowedFileExtensions: ['jpg', 'png', 'jpeg'],
        language: 'es',
        showCancel: false,
        showRemove: false,
        fileActionSettings: {
          showRemove: false,
          showZoom: false,
        },
        focusCaptionOnBrowse: false,
        focusCaptionOnClear: false,
        layoutTemplates: {
          fileIcon: '<i class="ft-image"></i>',
        }
      });

      $('#foto-group').on('click', '.file-caption-name', function () {
        $('#fotos').click()
      })
    })

    let dato = function(index) {
      return `<tr class="tr-dato">
                <td class="text-center">${index}</td>
                <td>
                  <input class="form-control" type="text" name="datos[${index}][descripcion]" maxlength="100" value="">
                </td>
                <td>
                  <input class="form-control" type="text" name="datos[${index}][observacion]" maxlength="100" value="">
                </td>
                <td>
                  <input class="form-control" type="number" min="1" step="0.01" step="99999999" name="datos[${index}][referencia]" value="">
                </td>
              </tr>`
    }

    let btn = $('.btn-new-dato')

    function addDato(){
      let count = $('.tr-dato').length
      
      if($('.tr-dato').length < 12){
        $('#tbody').append(dato( count + 1 ))
        toggleBtn()
      }
    }

    function toggleBtn(){
      let shouldDisable = ($('.tr-dato').length > 11)

      btn.prop('disabled', shouldDisable)
    }
  </script>
@endsection
