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
      body{
        background-color: #fff;
        font-size: .6rem;
      }
      p.text-title{
        font-family: "Segoe UI",sans-serif !important;
        font-size: 24px;
      }
      .text-center,
      td.text-center{
        text-align: center !important;
      }
    </style>

    @yield('head', '')
  </head>
  <body>
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
