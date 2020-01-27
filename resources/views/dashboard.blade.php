@extends('layouts.app')

@section('title', 'Inicio - '.config('app.name'))

@section('brand')
  <a class="navbar-brand" href="{{ route('dashboard') }}"> Inicio </a>
@endsection

@section('content')

  @include('partials.flash')
  
  <div class="row">
    @if(Auth::user()->isAdmin())
      <div class="col-lg-3 col-sm-6">
        <a href="{{ route('admin.users.index') }}">
          <div class="card card-stats">
            <div class="card-body">
              <div class="row">
                <div class="col-5">
                  <div class="icon-big text-center text-muted card-hover-danger">
                    <i class="fa fa-users"></i>
                  </div>
                </div>
                <div class="col-7">
                  <div class="numbers">
                    <p class="card-category">Usuarios</p>
                    <h4 class="card-title">{{ $users }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-sm-6">
        <a href="{{ route('admin.cliente.index') }}">
          <div class="card card-stats">
            <div class="card-body">
              <div class="row">
                <div class="col-5">
                  <div class="icon-big text-center text-muted card-hover-danger">
                    <i class="fa fa-address-book"></i>
                  </div>
                </div>
                <div class="col-7">
                  <div class="numbers">
                    <p class="card-category">Clientes</p>
                    <h4 class="card-title">{{ $clientes }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-sm-6">
        <a href="{{ route('admin.vehiculo.index') }}">
          <div class="card card-stats">
            <div class="card-body">
              <div class="row">
                <div class="col-5">
                  <div class="icon-big text-center text-muted card-hover-danger">
                    <i class="fa fa-car"></i>
                  </div>
                </div>
                <div class="col-7">
                  <div class="numbers">
                    <p class="card-category">Vehículos</p>
                    <h4 class="card-title">{{ $vehiculos }}</h4>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </a>
      </div>
    @endif

    <div class="col-lg-3 col-sm-6">
      <a href="{{ route('insumos.index') }}">
        <div class="card card-stats">
          <div class="card-body">
            <div class="row">
              <div class="col-5">
                <div class="icon-big text-center text-muted card-hover-danger">
                  <i class="fa fa-th-large"></i>
                </div>
              </div>
              <div class="col-7">
                <div class="numbers">
                  <p class="card-category">Insumos</p>
                  <h4 class="card-title">{{ $insumos }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>
@endsection
