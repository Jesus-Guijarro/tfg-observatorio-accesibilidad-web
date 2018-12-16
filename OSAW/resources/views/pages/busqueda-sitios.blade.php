@extends('layouts.master')

@section('titulo', 'Busqueda-sitios-por-nombre')

@section('content')
    
    <h1 class="h1-titulo"> Resultados de búsqueda</h1>

    <div style="margin-bottom: 1.5em">
        <form method="GET" action="{{ action('SitioController@busquedaSitio') }}">
                <label for="nombre" >Buscar Sitio Web:  </label>
                <input type="text" id ="nombre" name="nombre" value="{{$nombre}}" required autofocus>
                {{ csrf_field() }}
        </form>
    </div>

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


    @if( count($sitios) !== 0)
    <table style>
        <tr>
            <th>Sitio web</th>
            <th>URL</th>
            <th>Categoria Institucional</th>
        </tr>
        @foreach ($sitios as $sitio)
            <tr>
                <td > <a href="/sitio/{{ $sitio['id'] }}" style="color: black; text-decoration-line: underline">{{$sitio->nombre}}</a></td>
                <td > <a href="http://{{ $sitio['dominio'] }}" target="_blank">{{$sitio->dominio}}</a></td>
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