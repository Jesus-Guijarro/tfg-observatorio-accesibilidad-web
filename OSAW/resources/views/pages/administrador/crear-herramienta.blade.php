@extends('layouts.master')

@section('titulo', 'Añadir herramienta')

@section('content')

<h1 class="h1-encabezado"> Añadir herramienta web </h1>



@if(session()->has('mensaje'))
    <div class="alert alert-success">
        {{ session()->get('mensaje') }}
    </div>
@endif
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{  action('HerramientaController@crearHerramienta') }}">
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre herramienta</label>

                            <div class="col-md-8">
                                <input id="nombre" type="text"  name="nombre" value="{{ old('nombre') }}" style="width: 20em" autofocus>

                                @if ($errors->has('nombre'))
                                    <span >
                                        <strong class="strong-val">{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="descripcion" class="col-md-4 col-form-label text-md-right">Descripción</label>

                            <div class="col-md-8">
                                <input id="descripcion" type="text"  name="descripcion" value="{{ old('descripcion') }}" style="width: 20em" required>

                                @if ($errors->has('descripcion'))
                                    <span>
                                        <strong class="strong-val">{{ $errors->first('descripcion') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Añadir herramienta
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<a class="btn btn-default" href="/gestionar-herramientas" role="button">Volver a gestionar herramientas</a>
@endsection