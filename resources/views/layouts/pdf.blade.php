<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8"/>
    <title>@yield('title', config('app.name'))</title>
    <!-- CSRF Token -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <!-- CSS Files -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <style type="text/css">
      *, ::after, ::before {
        box-sizing: border-box;
      }
      @page{
        margin: 0cm 0cm;
      }
      body{
        background-color: #fff;
        font-size: .6rem;
        margin: 2cm 2cm 2.5cm 2cm;
      }
      header, footer{
        position: fixed;
        left: 0;
        right: 0;
        height: 2cm;
      }
      header{
        top: 0;
      }
      footer{
        bottom: 0;
      }
      p.text-title{
        font-family: "Segoe UI",sans-serif !important;
        font-size: 24px;
      }
      .text-center,
      td.text-center{
        text-align: center !important;
      }
      .timbre-container{
        position: relative;
        width: 30%;
        margin: 0 auto;
        padding-bottom: 0.5cm;
      }
      .page-break{
        page-break-after: always;
      }
      .pdf-row{
        margin: 0;
        width: 100%;
        margin-bottom: 10px;
        padding: 0 1%;
      }
      .pdf-row:before,
      .pdf-row:after{
        display: table;
        content: " ";
      }
      .pdf-row:after{
        clear: both;
      }
      .pdf-column{
        position: relative;
        float: left;
        min-height: 1px;
        width: 46%;
        padding: 0 10px;
      }
      .pdf-image-container{
        position: relative;
        height: 250px;
        text-align: center;
        overflow: hidden;
      }
      .pdf-image-container img{
        width: auto !important;
        height: auto !important;
        max-height: 100% !important;
        max-width: 100% !important;
      }
    </style>

    @yield('head', '')
  </head>
  <body>
    <header class="text-center">
    </header>
    <footer class="text-center">
      @if(Auth::user()->tallerHasTimbre())
        <div class="timbre-container">
          <img src="{{ asset('storage/'.Auth::user()->tallerTimbre) }}" alt="Timbre" style="width: auto; height: auto; max-height: 100%; max-width: 100%;">
        </div>
      @endif
    </footer>
    <div class="container">
      <table class="table table-sm border-0" style="width: 100%;">
        <tbody>
          <tr class="border-bottom border-primary">
            <td class="border-0">
              <img src="{{ asset('images/logo.png') }}" alt="" width="150">
            </td>
            <td class="border-0 align-bottom text-right">
              <p class="text-muted m-0 text-title">@yield('documento')</p>
            </td>
          </tr>
          <tr>
            <td>
              <p class="text-center text-muted m-0 text-title">Automotora La Tirana</p>
              <p class="text-center">
                <small>
                  Servicio automotriz especializado</br>
                  Av Arturo Prat 5587 KM 10 Bajo Molle,</br>
                  acceso caletera Sur - Galpon 4
                </small>
              </p>
            </td>
            <td class="text-right"><strong>FECHA:</strong> {{ date('d-m-Y') }}</td>
          </tr>
        </tbody>
      </table>

      @yield('content')
    </div>
  </body>
</html>
