@extends('layouts.app')

@section('title', 'Usuarios - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('admin.users.index') }}"> Usuarios </a>
@endsection

@section('content')

  @include('partials.flash')

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">
            <i class="fa fa-users"></i> Jefes de taller ({{ $jefes->count() }})
          </h4>
          @if(Auth::user()->isAdmin())
          <a class="btn btn-primary btn-fill btn-xs mb-2" href="{{ route('admin.users.create') }}">
            <i class="fa fa-plus"></i> Agregar Jefe de taller
          </a>
          @endif
        </div>
        <div class="card-body">
          <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Email</th>
                <th scope="col" class="text-center">Nombres</th>
                <th scope="col" class="text-center">Apellidos</th>
                <th scope="col" class="text-center">Agregado</th>
              </tr>
            </thead>
            <tbody class="text-center">
              @foreach($jefes as $d)
                <tr>
                  <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                  <td>
                    <a href="{{ route('admin.users.show', ['user' => $d->id] )}}">
                      {{ $d->email }}
                    </a>
                  </td>
                  <td>{{ $d->nombres }}</td>
                  <td>{{ $d->apellidos }}</td>
                  <td>{{ $d->created_at->format('d-m-Y H:i:s') }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
@endsection
