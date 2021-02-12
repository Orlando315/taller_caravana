@extends('layouts.app')

@section('title', 'Repuestos - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.repuesto.index') }}"> Repuestos </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Repuestos ({{ $repuestos->count() }})</h4>
          @if(Auth::user()->isAdmin())
            <a class="btn btn-primary btn-fill btn-xs mt-2" href="{{ route('admin.repuesto.create') }}">
              <i class="fa fa-plus"></i> Agregar Repuesto
            </a>
            <a class="btn btn-primary btn-fill btn-xs mt-2" href="{{ route('admin.repuesto.create.masivo') }}">
              <i class="fa fa-upload"></i> Carga masiva
            </a>
          @endif
        </div>
        <div class="card-body">
          <table id="table-respuestos" class="table table-striped table-bordered table-hover table-sm" style="width: 100%">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Sistema</th>
                <th scope="col" class="text-center">Componente</th>
                <th scope="col" class="text-center">Marca</th>
                <th scope="col" class="text-center">Modelo</th>
                <th scope="col" class="text-center">N° de parte</th>
                <th scope="col" class="text-center">N° de OEM</th>
              </tr>
            </thead>
            <tbody>
              @foreach($repuestos as $repuesto)
                <tr>
                  <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                  <td>
                    <a href="{{ route('admin.repuesto.show', ['repuesto' => $repuesto->id] )}}">
                      {{ $repuesto->sistema ?? 'N/A' }}
                    </a>
                  </td>
                  <td>{{ $repuesto->componente ?? N/A }}</td>
                  <td>{{ $repuesto->marca->marca }}</td>
                  <td>{{ $repuesto->modelo->modelo }}</td>
                  <td>{{ $repuesto->nro_parte ?? 'N/A' }}</td>
                  <td>{{ $repuesto->nro_oem ?? 'N/A' }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function() {
      // Setup - add a text input to each footer cell
      $('#table-respuestos thead tr').clone(true).appendTo('#table-respuestos thead');
      $('#table-respuestos thead tr:eq(1) th').each( function (i) {
        if(i == 0){ $(this).html(''); return; }

        let title = $(this).text();
        $(this).html('<input class="form-control form-control-sm" type="text" placeholder="Buscar '+title+'"/>');
        $('input', this).on('keyup change', function () {
          if(table.column(i).search() !== this.value){
            table
              .column(i)
              .search(this.value)
              .draw();
          }
        });
      });

      let table = $('#table-respuestos').DataTable({
        responsive: true,
        language: {
          url: '{{ asset("js/plugins/datatables/spanish.json") }}'
        },
        orderCellsTop: true,
        fixedHeader: true
      });
    });
  </script>
@endsection
