@extends('layouts.app')

@section('title', 'Repuestos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.repuesto.index') }}"> Repuestos </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('admin.repuesto.store.masivo') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <h4 class="m-0">Agregar Repuestos Internacionales <small><a class="btn btn-xs btn-fill btn-success" href="{{ asset('formatos/formato_repuestos.xlsx') }}"><i class="fa fa-file-excel-o"></i> Descargar formato</a></small></h4>
            <small class="text-muted">Debe seleccionar un archivo con el formato proporcionado y cargar la información antes de Guardar</small>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="archivo" class="control-label" data-browse="Elegir">Archivo: *</label>
                  <div class="custom-file">
                    <input id="archivo" class="custom-file-input{{ $errors->has('archivo') ? ' is-invalid' : '' }}" type="file" name="archivo" required accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                    <label class="custom-file-label" for="archivo" data-browse="Elegir">Seleccionar</label>
                  </div>
                  <small class="form-text text-muted">Formatos admitidos: .xls, .xlsx</small>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>&nbsp;</label>
                  <div class="pt-1">
                    <button class="btn btn-sm btn-primary btn-fill load-file" type="button" disabled><i class="fa fa-upload"></i> Cargar información</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="alert alert-danger alert-important alert-repuesto"{!! (count($errors) > 0) ? '' : 'style="display:none"' !!}>
              <ul class="m-0">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            
            <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <th>-</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Descripción</th>
                    <th>PU</th>
                    <th>Cant.</th>
                    <th>Costo</th>
                    <th>Porc/%</th>
                    <th>Envio 1</th>
                    <th>Envio 2</th>
                    <th>Costo + Envio</th>
                    <th>Impuestos</th>
                    <th>Costo</th>
                    <th>GG</th>
                    <th>Venta</th>
                  </tr>
                </thead>
                <tbody id="tbody">
                </tbody>
              </table>
            </div>

            <div class="form-group text-right">
              <a class="btn btn-default" href="{{ route('admin.repuesto.index') }}"><i class="fa fa-reply"></i> Atras</a>
              <button id="btn-store-repuestos" class="btn btn-primary" type="submit" disabled><i class="fa fa-send"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    const ALERT_REPUESTO = $('.alert-repuesto');
    const MARCAS = @json($marcas);
    const TBODY = $('#tbody');
    const STOREBTN = $('#btn-store-repuestos');
    var marcasOptions;

    let rowRepuesto = function (repuesto){
      return `
        <tr class="row-repuesto">
          <td><button class="btn btn-xs btn-danger btn-delete m-0" type="button"><i class="fa fa-times"</i></button></td>
          <td><select class="form-control select-marca" name="repuesto[marca][]" required style="width:100%"><option value="">Seleccione...</option>${marcasOptions}</select></td>
          <td><select class="form-control select-modelo" name="repuesto[modelo][]" required disabled style="width:100%"><option value="">Seleccione...</option></select></td>
          <td>${repuesto.descripcion}</td>
          <td class="text-right">${repuesto.precio.toLocaleString('de-DE')}</td>
          <td class="text-center">${repuesto.cantidad}</td>
          <td class="text-right">${repuesto.costo.toLocaleString('de-DE')}</td>
          <td class="text-right">${repuesto.porcentaje.toLocaleString('de-DE')}</td>
          <td class="text-right">${repuesto.envio1.toLocaleString('de-DE')}</td>
          <td class="text-right">${repuesto.envio2.toLocaleString('de-DE')}</td>
          <td class="text-right">${repuesto.costo_envio.toLocaleString('de-DE')}</td>
          <td class="text-right">${repuesto.impuestos.toLocaleString('de-DE')}</td>
          <td class="text-right">${repuesto.costo_total.toLocaleString('de-DE')}</td>
          <td class="text-right">${repuesto.gasto_general.toLocaleString('de-DE')}</td>
          <td class="text-right">${repuesto.venta.toLocaleString('de-DE')}</td>
        </tr>`;
    }

    $(document).ready(function () {
      TBODY.on('change', '.select-marca', function () {
        let marca = $(this).val();
        let field = $(this).closest('.row-repuesto').find('.select-modelo');

        if(!marca){ return false }

        $.ajax({
          type: 'POST',
          url: `{{ route("vehiculo.marca.modelos") }}/${marca}/modelos`,
          data: {
            _token: '{{ csrf_token() }}'
          },
          cache: false,
          dataType: 'json',
        })
        .done(function (modelos) {
          field.html('<option value="">Seleccione...</option>');
          $.each(modelos, function(k, modelo){
            field.append(`<option value="${modelo.id}">${modelo.modelo}</option>`)
          })

          field.prop('disabled', false)
        })
        .fail(function () {
          STOREBTN.prop('disabled', true)
          field.prop('disabled', true)
        })
      })
      
      $('.custom-file-input').change(function(e){
        let files = e.target.files;
        let id = $(this).attr('id')

        $(this).siblings(`label[for="${id}"]`).text(files[0].name);
      });

      $('.btn-delete').click(function () {
        $(this).closest('.row-repuesto').remove()
      });

      $('#archivo').change(function () {
        if(this.files && this.files[0]){
          let file = this.files[0];

          if([
              'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]
            .includes(file.type)) {
              changeLabel(file.name)
              $('.load-file').prop('disabled', false)
          }else{
            changeLabel('Seleccionar')
            showAlert('El archivo no es de un tipo admitido.')
            $('.load-file').prop('disabled', true)
          }
        }
      })

      // Cargar Excel
      $('.load-file').click(function (){
        let archivo = $('#archivo')[0];

        if(archivo.files.length === 0){
          showAlert('No hay ningún archivo seleccionado.');
          return false;
        }

        TBODY.empty();

        let formData = new FormData();
        formData.append('archivo', archivo.files[0]);

        $.ajax({
          type: 'POST',
          url: '{{ route("admin.repuesto.create.masivo.upload") }}',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
        })
        .done(function (response) {
          if(response.response){
            $.each(response.repuestos, function (k, repuesto){
              TBODY.append(rowRepuesto(repuesto));
            })

            $('.select-marca, .select-modelo').select2({
              placeholder: 'Seleccione...',
            });
            STOREBTN.prop('disabled', false)
          }else{
            STOREBTN.prop('disabled', true)
            showAlert('Ha ocurrido un error al cargar el archivo. Revise el formato utilizado')
          }
        })
        .fail(function (response) {
          showAlert()
          STOREBTN.prop('disabled', true)
        })
      })

      buildMarcaOptions()
    }) // DOM Ready

    // Construir los options del select de marcas
    function buildMarcaOptions(){
      marcasOptions = '';

      $.each(MARCAS, function (value, marca){
        marcasOptions += `<option value="${value}">${marca}</option>`;
      })
    }

    // Cambiar el nombre del label del input file, y colocar el nombre del archivo
    function changeLabel(name){
      $('#archivo').siblings('label[for="archivo"]').text(name);
    }

    // Mostrar error
    function showAlert(error = 'Ha ocurrido un error'){
      ALERT_REPUESTO.empty().append(`<li>${error}</li>`)
      ALERT_REPUESTO.show().delay(5000).hide('slow')
      $('#archivo').val('')
      changeLabel('Seleccionar')
    }
  </script>
@endsection
