@extends('layouts.master')

@section('titulo', 'Añadir herramienta')

@section('content')

<h1 class="h1-titulo"> Añadir herramienta web </h1>

@if(session()->has('mensaje'))
    <div class="alert alert-success">
        {{ session()->get('mensaje') }}
    </div>
@endif

<form method="POST" action="{{  action('HerramientaController@crearHerramienta') }}">
    @csrf

    <div class="form-group row">
        <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre herramienta</label>

        <div class="col-md-8">
            <input id="nombre" type="text"  name="nombre" value="{{ old('nombre') }}" required autofocus>

            @if ($errors->has('nombre'))
                <span>
                    <strong class="strong-val">{{ $errors->first('nombre') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label for="descripcion" class="col-md-4 col-form-label text-md-right">Descripción</label>

        <div class="col-md-8">
            <input id="descripcion" type="text"  name="descripcion" value="{{ old('descripcion') }}" required>

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
            <a class="btn btn-default" href="/gestionar-herramientas" role="button">Cancelar</a>
            
        </div>
    </div>
</form>
@endsection