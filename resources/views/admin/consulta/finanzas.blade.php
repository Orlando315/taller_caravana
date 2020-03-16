@extends('layouts.app')

@section('title', 'Consultar finanzas - '.config('app.name'))

@section('head')
  <!-- datepicker -->
  <link rel="stylesheet" type="text/css" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
@endsection

@section('brand')
  <a class="navbar-brand" href="#"> Finanzas </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <form id="finanzas" action="{{ route('admin.consulta.finanzas.get') }}" method="POST">
            @csrf
            <h4>Consultar finanzas</h4>

            <div class="form-group">
              <div class="input-daterange input-group">
                <input id="inicioExport" type="text" class="form-control" name="inicio" placeholder="yyyy-mm-dd" required>
                <span class="input-group-addon">Hasta</span>
                <input id="finExport" type="text" class="form-control" name="fin" placeholder="yyyy-mm-dd" required>
              </div>
            </div>

            <div class="form-group text-right">
              <a class="btn btn-default" href="{{ route('dashboard') }}"><i class="fa fa-reply"></i> Atras</a>
              <button id="finanzas-btn" class="btn btn-primary" type="submit"><i class="fa fa-send"></i> Consultar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <div class="row justify-content-center">
    <div class="col-md-10" style="display: none">
      <div class="alert alert-dismissible alert-danger alert-option" role="alert">
        <strong class="text-center">Ha ocurrido un error</strong> 

        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item" rel="tooltip" title="Total de ventas">
              Total ventas: <span id="ventas">-</span>
            </li>
            <li class="list-group-item" rel="tooltip" title="Pagos pendientes por cotizaciones abiertas">
              Pagos pendientes: <span id="pendientes">-</span>
            </li>
            <li class="list-group-item" rel="tooltip" title="Utilidades por cotizaciones cerrdas">
              Total utilidades: <span id="utilidades">-</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <!-- datepicker -->
  <script type="text/javascript" src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      let btn = $('#finanzas-btn'),
          alert = $('.alert');

      $('.input-daterange').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',
        keyboardNavigation: false
      });

      $('#finanzas').submit(function(e){
        e.preventDefault()

        btn.prop('disabled', true)

        let form = $(this),
            action = form.attr('action');

        $.ajax({
          type: 'POST',
          data: form.serialize(),
          url: action,
          dataType: 'json'
        })
        .done(function (data) {
          if(data.response == true){
            $('#ventas').text(data.finanzas.ventas)
            $('#pendientes').text(data.finanzas.pendiente)
            $('#utilidades').text(data.finanzas.utilidades)
          }else{
            alert.show().delay(7000).hide('slow');
          }
        })
        .fail(function (response) {
          alert.show().delay(7000).hide('slow');
        })
        .always(function () {
          btn.prop('disabled', false)
        })
      })
    })
  </script>
@endsection
