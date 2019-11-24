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
            <i class="fa fa-users"></i> Usuarios
          </h4>
        </div>
        <div class="card-body">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="users-tab" href="#users" role="tab" data-toggle="tab" aria-controls="users" aria-selected="true">Usuarios ({{ $users->count() }})</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="jefes-tab" href="#jefes" role="tab" data-toggle="tab" aria-controls="jefes" aria-selected="false">Jefes de taller ({{ $jefes->count() }})</a>
            </li>
          </ul>
          <div class="tab-content">
            <div id="users" class="tab-pane fade show active" role="tabpanel" aria-labelledby="users-tab">
              <a class="btn btn-primary btn-fill btn-xs my-2" href="{{ route('admin.users.create', ['role' => 'user']) }}">
                <i class="fa fa-plus"></i> Agregar Usuario
              </a>

              <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Nombres</th>
                    <th scope="col" class="text-center">Apellidos</th>
                    <th scope="col" class="text-center">Email</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($users as $d)
                    <tr>
                      <td scope="row" class="text-center">{{ $loop->index + 1 }}</td>
                      <td>{{ $d->nombres }}</td>
                      <td>{{ $d->apellidos }}</td>
                      <td>
                        <a href="{{ route('admin.users.show', ['user' => $d->id] )}}" title="Ver usuario">
                          {{ $d->email }}
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              
            </div><!-- .tab-pane -->
            <div id="jefes" class="tab-pane fade" role="tabpanel" aria-labelledby="jefes-tab" aria-expanded="false">
              <a class="btn btn-primary btn-fill btn-xs my-2" href="{{ route('admin.users.create', ['role' => 'jefe']) }}">
                <i class="fa fa-plus"></i> Agregar Jefe de taller
              </a>

              <table class="table data-table table-striped table-bordered table-hover table-sm" style="width: 100%">
                <thead>
                  <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">Nombres</th>
                    <th scope="col" class="text-center">Apellidos</th>
                    <th scope="col" class="text-center">Email</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  @foreach($jefes as $d)
                    <tr>
                      <td scope="row" class="text-center">{{ $loop->index + 1 }}</td>
                      <td>{{ $d->nombres }}</td>
                      <td>{{ $d->apellidos }}</td>
                      <td>
                        <a href="{{ route('admin.users.show', ['user' => $d->id] )}}" title="Ver usuario">
                          {{ $d->email }}
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              
            </div><!-- .tab-pane -->
          </div><!-- .tab-content -->
        </div><!-- .card-body -->
      </div>
    </div>
  </div>
@endsection
