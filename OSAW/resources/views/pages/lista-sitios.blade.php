@extends('layouts.master')

@section('titulo', 'Listado-sitios')

@section('content')
    
    <h1 class="h1-titulo"> Listado completo de sitios webs evaluados</h1>

    <div style="margin-bottom: 1.5em">
        <form method="GET">
                <label for="categoria" >Filtrar por Categoria Institucional:  </label>
                <select>
                    @foreach ($categorias as $categoria)
                    <option value="{{$categoria->id}}">{{$categoria->descripcion}}</option>
                    @endforeach
                </select>
                {{ csrf_field() }}
        </form>
    </div>


    <table>
        <tr>
            <th>Sitio web</th>
            <th>URL</th>
            <th>Páginas webs evaluadas</th>
            <th>Categoria Institucional</th>
        </tr>
        @foreach ($sitios as $sitio)
            <tr>
                <td > <a href="/sitio/{{ $sitio->id }}" style="color: black; text-decoration-line: underline">{{$sitio->nombre}}</a></td>
                <td > <a href="http://{{ $sitio->dominio }}" target="_blank">{{$sitio->dominio}}</a></td>
                <td > {{$sitio->num_paginas}}</td>
                <td> {{$sitio->descripcion}}</td>
            </tr>
        @endforeach
    </table>
    <div class="div-links">
        {{ $sitios->links() }}
    </div>

@endsection