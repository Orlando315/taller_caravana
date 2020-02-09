@extends('layouts.app')

@section('title', 'Inspección - '.config('app.name'))

@section('head')
  <!-- fileinput -->
  <link rel="stylesheet" type="text/css" href="{{ asset('js/plugins/fileinput/fileinput.min.css')}}">
@endsection

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.proceso.show', ['proceso' => $proceso->id]) }}"> Inspección </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.inspeccion.store', ['proceso' => $proceso->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h4>Inspección de recepción</h4>
            
            <h5 class="text-center">{{ $proceso->cliente->nombre().' | '.$proceso->vehiculo->vehiculo() }}</h5>

            <div id="foto-group" class="form-group">
              <label for="fotos">Fotos:</label>
              <div class="file-loading">
                <input id="fotos" type="file" name="fotos[]" data-msg-placeholder="Seleccionar..." accept="image/jpeg,image/png" multiple>
              </div>
              <small class="text-muted">Hasta 6 fotos de 12 MB c/u</small>
            </div>

            <div class="form-group">
              <label class="control-label" for="combustible">Combustible: </label>
              <input id="combustible" class="form-control{{ $errors->has('combustible') ? ' is-invalid' : '' }}" type="number" step="0.1" min="0" max="99999999" name="combustible" value="{{ old('combustible') }}" placeholder="Combustible">
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-8">
                    Radio
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="radio" {{ old('radio') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Antena
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="antena" {{ old('antena') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Pisos delanteros
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="pisos_delanteros" {{ old('pisos_delanteros') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Pisos traseros
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="pisos_traseros" {{ old('pisos_traseros') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Cinturones
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="cinturones" {{ old('cinturones') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Tapiz
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="tapiz" {{ old('tapiz') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Triángulos
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="triangulos" {{ old('triangulos') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Extintor
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="extintor" {{ old('extintor') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Botiquín
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="botiquin" {{ old('botiquin') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Gata
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="gata" {{ old('gata') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Herramientas
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="herramientas" {{ old('herramientas') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Neumático repuesto
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="neumatico_repuesto" {{ old('neumatico_repuesto') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-8">
                    Luces altas
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="luces_altas" {{ old('luces_altas') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Luces bajas
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="luces_bajas" {{ old('luces_bajas') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Intermitentes
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="intermitentes" {{ old('intermitentes') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Encendedor
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="encendedor" {{ old('encendedor') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Limpia parabrisas delantero
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="limpia_parabrisas_delantero" {{ old('limpia_parabrisas_delantero') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Limpia parabrisas trasero
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="limpia_parabrisas_trasero" {{ old('limpia_parabrisas_trasero') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Tapa de combustible
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="tapa_combustible" {{ old('tapa_combustible') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Seguro de ruedas
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="seguro_ruedas" {{ old('seguro_ruedas') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Perilla interior
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="perilla_interior" {{ old('perilla_interior') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Perilla exterior
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="perilla_exterior" {{ old('perilla_exterior') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Manuales
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="manuales" {{ old('manuales') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    Documentación
                  </div>
                  <div class="col-md-4">
                    <input class="form-control" type="checkbox" name="documentacion" {{ old('documentacion') == 'on' ? 'checked' : '' }} data-toggle="switch" data-on-color="info" data-off-color="info" data-on-text="<i class='fa fa-check'></i>" data-off-text="<i class='fa fa-times'></i>">
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label for="observacion">Observación:</label>
              <textarea id="observacion" class="form-control{{ $errors->has('observacion') ? ' is-invalid' : '' }}" name="observacion" maxlength="250">{{ old('observacion') }}</textarea>
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
@endsection

@section('scripts')
  <!-- Bootstrap Switch -->
  <script type="text/javascript" src="{{ asset('js/plugins/bootstrap-switch.js') }}"></script>
  <!-- fileinput -->
  <script type="text/javascript" src="{{ asset('js/plugins/fileinput/fileinput.min.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/plugins/fileinput/locales/es.js') }}"></script>

  <script type="text/javascript">
    $(document).ready(function () {
      $('#fotos').fileinput({
        overwriteInitial: false,
        initialPreviewShowDelete: false,
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
          showDrag: false,
          showDownload: false,
          showUpload: false,
        },
        focusCaptionOnBrowse: false,
        focusCaptionOnClear: false,
        autoOrientImage: false,
        layoutTemplates: {
          fileIcon: '<i class="ft-image"></i>',
        }
      });

      $('#foto-group').on('click', '.file-caption-name', function () {
        $('#fotos').click()
      })
    })

  </script>
@endsection
