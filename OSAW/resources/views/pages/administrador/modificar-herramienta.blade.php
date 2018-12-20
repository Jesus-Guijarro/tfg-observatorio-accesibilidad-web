@extends('layouts.master')

@section('titulo', 'Modificar paginas web')

@section('content')

<h1 class="h1-encabezado"> Modificar página web </h1>

@if(session()->has('mensaje'))
    <div class="alert alert-success">
        {{ session()->get('mensaje') }}
    </div>
@endif

<div style="margin-bottom: 1.5em">
    <form method="POST" action="<?php action('HerramientaController@modificarHerramienta', $herramienta->id)?>">
        <label for="nombre">Nombre</label>
        <input type="text" id ="nombre" name="nombre" value="{{$herramienta->nombre}}" required >

        @if ($errors->has('nombre'))
            <span>
                <strong class="strong-val">{{ $errors->first('nombre') }}</strong>
            </span>
        @endif

        <label for="descripcion">Descripcion</label>
        <input type="text" id ="descripcion" name="descripcion" value="{{$herramienta->descripcion}}" required >

        @if ($errors->has('descripcion'))
            <span>
                <strong class="strong-val">{{ $errors->first('descripcion') }}</strong>
            </span>
        @endif
        <button type="submit" class="btn btn-primary">
            Modificar
        </button>
        {{ csrf_field() }}
    </form>
</div>

<a href="/gestionar-herramientas">Volver a gestionar herramientas</a></td>  

@endsection