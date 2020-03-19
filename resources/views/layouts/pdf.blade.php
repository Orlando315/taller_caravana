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
      h4{
        font-family: "Segoe UI",sans-serif !important;
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
              <h4 class="text-muted m-0" style="font-family: sans-serif;">@yield('documento')</h4>
            </td>
          </tr>
          <tr>
            <td>
              <h4 class="text-center text-muted">Automotora La Tirana</h4>
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
