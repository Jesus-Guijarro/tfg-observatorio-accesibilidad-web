@extends('layouts.master')

@section('titulo', 'Gestionar sitios web')

@section('content')

<h1 class="h1-titulo"> Gestionar sitios web </h1>

<div style="margin-bottom: 1.5em">
    <a class="btn btn-primary" href="/crear-sitio" role="button">Añadir nuevo sitio web</a>
</div>

<div style="margin-bottom: 1.5em">
    <form method="GET" action="{{ action('SitioController@busquedaSitio') }}">
            <label for="nombre" >Buscar Sitio Web:  </label>
            <input type="text" id ="nombre" name="nombre" value="nombre" required autofocus>
            {{ csrf_field() }}
    </form>
</div>

@if( count($sitios) !== 0)
<table style>
    <tr>
        <th>Sitio web</th>
    </tr>
    @foreach ($sitios as $sitio)
        <tr>
            <td> <a href="/sitio/{{ $sitio['id'] }}" style="color: black; text-decoration-line: underline">{{$sitio->nombre}}</a></td>
            <td><a href="/modificar-sitio/{{ $sitio['id'] }}">Modificar</a></td>
            <td><a href="/sitio/{{ $sitio['id'] }}">Eliminar</a></td>
        </tr>
    @endforeach
</table>
<div>
    {{ $sitios->links() }}
</div>
@else
<p style="text-align: center"> No se ha podido encontrar ningún sitio web con el nombre buscado.</p>
@endif

@endsection