@extends('layouts.master')

@section('titulo', 'Busqueda-sitios-por-nombre')

@section('content')
    
    <h1 class="h1-titulo"> Resultados de búsqueda</h1>

    @if( count($sitios) !== 0)
    <table>
        <tr>
            <th>Sitio web</th>
            <th>URL</th>
            <th>Páginas webs evaluadas</th>
            <th>Categoria</th>
        </tr>
        @foreach ($sitios as $sitio)
            <tr>
                <td > <a href="/sitio/{{ $sitio['id'] }}" style="color: black; text-decoration-line: underline">{{$sitio->nombre}}</a></td>
                <td > <a href="http://{{ $sitio['dominio'] }}" target="_blank">{{$sitio->dominio}}</a></td>
                <td > {{$sitio->num_paginas}}</td>
                <td> {{$sitio->descripcion}}</td>
            </tr>
        @endforeach
    </table>
    <div class="div-links">
        {{ $sitios->links() }}
    </div>
    @else
    <p style="text-align: center"> No se ha podido encontrar ningún sitio web con el nombre buscado.</p>
    @endif

@endsection