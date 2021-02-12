@extends('layouts.app')

@section('title', 'Configuración - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('dashboard') }}"> Configuración </a>
@endsection

@section('content')

  @include('partials.flash')
  
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.configurations.update.dolar') }}" method="POST">
            @csrf
            @method('PATCH')

            <h4>Editar Dolar</h4>

            <div class="form-group">
              <label class="control-label" for="dolar">Dolar:</label>
              <input id="dolar" class="form-control{{ $errors->has('dolar') ? ' is-invalid' : '' }}" type="number" name="dolar" step=".1" min="0" max="999999999" value="{{ old('dolar', $configuracion->dollar) }}" placeholder="Dolar">
            </div>

            @if(count($errors) > 0 && $errors->has('dolar'))
            <div class="alert alert-danger alert-important">
              <ul class="m-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif

            <div class="form-group text-right">
              <a class="btn btn-default" href="{{ route('dashboard') }}"><i class="fa fa-reply"></i> Atras</a>
              <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.configurations.update.ganancia') }}" method="POST">
            @csrf
            @method('PATCH')

            <h4>Porcentaje de ganancia</h4>

            <div class="form-group">
              <label class="control-label" for="ganancia">Ganancia:</label>
              <input id="ganancia" class="form-control{{ $errors->has('ganancia') ? ' is-invalid' : '' }}" type="number" name="ganancia" step=".01" min="0" max="100" value="{{ old('ganancia', $configuracion->ganancia) }}" placeholder="Ganancia">
            </div>

            @if(count($errors) > 0 && $errors->has('ganancia'))
            <div class="alert alert-danger alert-important">
              <ul class="m-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif

            <div class="form-group text-right">
              <a class="btn btn-default" href="{{ route('dashboard') }}"><i class="fa fa-reply"></i> Atras</a>
              <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.configurations.update.timbre') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <h4>Timbre</h4>

            <div class="form-group">
              <label for="imagen">Imagen: *</label>
              <section class="text-center">
                <a id="imagen-link" href="#" type="button">
                  <img id="imagen-placeholder" class="img-responsive border p-1 mb-2" src="{{ asset(($configuracion->timbre ? 'storage/'.$configuracion->timbre : 'images/default.jpg')) }}" alt="imagen" style="max-height:120px;margin: 0 auto;max-width:250px;">
                </a>
              </section>
              <div class="custom-file">
                <input id="imagen" class="custom-file-input{{ $errors->has('imagen') ? ' is-invalid' : '' }}" type="file" name="imagen" data-msg-placeholder="Seleccionar" accept="image/jpeg,image/png">
                <label class="custom-file-label" for="imagen">Seleccionar</label>
              </div>
              <small class="form-text text-muted">Tamaño máximo permitido: 3MB</small>
            </div>

            <div class="alert alert-danger alert-important"{!! count($errors) > 0 ? '' : 'style="display:none"' !!}>
              <ul class="m-0">
                @if($errors->has('imagen'))
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                @endif
              </ul>
            </div>

            <div class="form-group text-right">
              <a class="btn btn-default" href="{{ route('dashboard') }}"><i class="fa fa-reply"></i> Atras</a>
              <button class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    const defaultImge = @json(asset('imgages/default.jpg'));

    $(document).ready(function() {
      $('#imagen-link').click(function (e) {
        e.preventDefault();

        $('#imagen').trigger('click')
      })

      $('#imagen').change(function () {
        if(this.files && this.files[0]){
          let file = this.files[0];

          if(['image/png', 'image/jpeg'].includes(file.type)){
            if(file.size < 3000000){
              changeLabel(file.name)
              preview(this.files[0])
            }else{
              changeLabel('Seleccionar')
              showAlert('La imagen debe ser menor a 3MB.')
            }
          }else{
            changeLabel('Seleccionar')
            showAlert('El archivo no es un tipo de imagen valida.')
          }
        }
      })
    })

    // Cambiar el nombre del label del input file, y colocar el nombre del archivo
    function changeLabel(name){
      $('#imagen').siblings(`label[for="imagen"]`).text(name);
    }

    function preview(input) {
      let reader = new FileReader();
  
      reader.onload = function (e){
        let holder = document.getElementById('imagen-placeholder')
        holder.src = e.target.result
      }

      reader.readAsDataURL(input)
    }

    function showAlert(error = 'Ha ocurrido un error'){
      $('.alert ul').empty()
      $('.alert ul').append(`<li>${error}</li>`)
      $('.alert').show().delay(5000).hide('slow')
      $('#imagen').val('')
      document.getElementById('imagen-placeholder').src = defaultImge
    }
  </script>
@endsection
