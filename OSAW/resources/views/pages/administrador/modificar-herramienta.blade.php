@extends('layouts.master')

@section('titulo', 'Modificar paginas web')

@section('content')

<h1 class="h1-encabezado"> Modificar página web </h1>

@if(session()->has('mensaje'))
    <div class="alert alert-success">
        {{ session()->get('mensaje') }}
    </div>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php action('HerramientaController@modificarHerramienta', $herramienta->id)?>">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre</label>
                        <input type="text" id ="nombre" name="nombre" value="{{$herramienta->nombre}}" required >

                        @if ($errors->has('nombre'))
                            <span>
                                <strong class="strong-val">{{ $errors->first('nombre') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <label for="descripcion" class="col-md-4 col-form-label text-md-right" >Descripcion</label>
                        <input type="text" id ="descripcion" name="descripcion" value="{{$herramienta->descripcion}}" required >

                        @if ($errors->has('descripcion'))
                            <span>
                                <strong class="strong-val">{{ $errors->first('descripcion') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="row justify-content-center">
                        <button type="submit" class="btn btn-primary">
                            Modificar
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="/gestionar-herramientas">Volver a gestionar herramientas</a></td>  

@endsection