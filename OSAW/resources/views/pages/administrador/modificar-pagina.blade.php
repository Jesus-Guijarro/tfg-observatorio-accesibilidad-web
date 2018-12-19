@extends('layouts.master')

@section('titulo', 'Gestionar paginas web')

@section('content')

<h1 class="h1-titulo"> Modificar página web </h1>

@if(session()->has('mensaje'))
    <div class="alert alert-success">
        {{ session()->get('mensaje') }}
    </div>
@endif

<div style="margin-bottom: 1.5em">
    <form method="POST" action="<?php action('PaginaController@modificarPagina', $id)?>">
        <label for="url">URL</label>
        <input type="text" id ="url" name="url" value="{{$pagina->URL}}"   required >

        @if ($errors->has('url'))
            <span>
                <strong class="strong-val">{{ $errors->first('url') }}</strong>
            </span>
        @endif
        <button type="submit" class="btn btn-primary">
            Modificar
        </button>
        {{ csrf_field() }}
    </form>
</div>

<a href="/gestionar-paginas/{{$pagina->sitio_id}}">Volver a gestionar páginas</a></td>  

@endsection