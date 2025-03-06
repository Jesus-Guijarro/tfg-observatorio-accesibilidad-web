@extends('layouts.master')

@section('titulo', 'Busqueda-sitios-por-nombre')

@section('content')
    
<h1 class="h1-encabezado"> Resultados de búsqueda</h1>

<hr>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div style="margin-bottom: 1.5em">
                <div class="row justify-content-center">

                    <div style="margin-bottom: 1.5em">
                        <form method="GET" action="{{ action('SitioController@busquedaSitio') }}">
                                <label for="nombre" >Buscar Sitio Web:  </label>
                                <input type="text" id ="nombre" name="nombre" value="{{$nombre}}" required autofocus>
                                {{ csrf_field() }}
                        </form>
                    </div>
                    <div style="margin-bottom: 1.5em">
                        <form method="POST" action="<?php action('SitioController@busquedaSitioPorCategoria') ?>">
                            {{ csrf_field() }}
                                <label for="nombre_post" hidden>Buscar Sitio Web:  </label>
                                <input type="text" id ="nombre_post" name="nombre_post" value="{{$nombre}}" hidden>
                                <label for="categoria" >Filtrar por Categoria Institucional:  </label>
                                <select id="categoria" name="categoria">
                                    @foreach ($categorias as $cat)
                                        @if(!empty($categoria))
                                            @if($cat->id===$categoria->id)
                                                <option value="{{$cat->id}}" selected>{{$cat->descripcion}}</option>
                                            @else
                                                <option value="{{$cat->id}}" >{{$cat->descripcion}}</option>
                                            @endif
                                        @else
                                            <option value="{{$cat->id}}" >{{$cat->descripcion}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            <button type="submit" class="btn btn-primary">
                                Filtrar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        @isset ($categoria)
            <h2> {{$categoria->descripcion}}</h2>
        @endisset

        @if( count($sitios) !== 0)
        <table class="table" summary="Tabla que muestra el resultado de la búsqueda por nombre de los sitios webs que hay registrados">
            <caption>Resultado búsqueda de sitio web</caption>
            <thead>
                <tr>
                    <th>Sitio web</th>
                    <th>URL</th>
                    <th>Categoria Institucional</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($sitios as $sitio)
                <tr>
                    <td > <a href="/sitio/{{ $sitio['id'] }}" >{{$sitio->nombre}}</a></td>
                    <td > <a href="http://{{ $sitio['dominio'] }}" target="_blank">{{$sitio->dominio}}</a></td>
                    <td> {{$sitio->descripcion}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="div-links">
            {{ $sitios->links() }}
        </div>
        @else
        <p style="text-align: center"> No se ha podido encontrar ningún sitio web con el nombre buscado.</p>
        @endif
        </div>
    </div>


@endsection