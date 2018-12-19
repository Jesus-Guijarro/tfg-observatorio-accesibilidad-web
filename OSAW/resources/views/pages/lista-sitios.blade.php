@extends('layouts.master')

@section('titulo', 'Listado-sitios')

@section('content')
    
    <h1 class="h1-titulo"> Listado de sitios webs evaluados</h1>

    <div style="margin-bottom: 1.5em">
        <form method="POST" action="<?php action('SitioController@listarSitiosPorCategoria') ?>">
            {{ csrf_field() }}
                <label for="categoria" >Filtrar por Categoria Institucional:  </label>
                <select name="categoria">
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

    @isset ($categoria)
        <h2> {{$categoria->descripcion}}</h2>
    @endisset
    <table>
        <tr>
            <th>Sitio web</th>
            <th>URL</th>
            <th>Categoria Institucional</th>
        </tr>
        @foreach ($sitios as $sitio)
            <tr>
                <td > <a href="/sitio/{{ $sitio->id }}" style="color: black; text-decoration-line: underline">{{$sitio->nombre}}</a></td>
                <td > <a href="http://{{ $sitio->dominio }}" target="_blank">{{$sitio->dominio}}</a></td>
                <td> {{$sitio->descripcion}}</td>
            </tr>
        @endforeach
    </table>
    <div class="div-links">
        {{ $sitios->links() }}
    </div>

@endsection