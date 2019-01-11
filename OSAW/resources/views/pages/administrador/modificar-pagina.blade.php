@extends('layouts.master')

@section('titulo', 'Modificar paginas web')

@section('content')

<h1 class="h1-encabezado"> Modificar página web </h1>

<hr>

@if(session()->has('mensaje'))
    <div class="alert alert-success">
        {{ session()->get('mensaje') }}
    </div>
@endif


<div class="row justify-content-center">
    <div style="margin-bottom: 1.5em">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="<?php action('PaginaController@modificarPagina', $id)?>">
                    <label for="url" hidden>Nueva URL: </label>
                    <input type="text" id ="url" name="url" value="{{$pagina->URL}}"  style="width: 40em" required >

                    
                    <button type="submit" class="btn btn-primary">
                        Modificar
                    </button>
                    {{ csrf_field() }}
                    <div>
                        @if ($errors->has('url'))
                            <span>
                                <strong class="strong-val">{{ $errors->first('url') }}</strong>
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<a href="/gestionar-paginas/{{$pagina->sitio_id}}">Volver a gestionar páginas</a></td>  

@endsection