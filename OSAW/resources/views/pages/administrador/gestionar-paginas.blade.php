@extends('layouts.master')

@section('titulo', 'Gestionar paginas web')

@section('content')

<h1 class="h1-titulo"> Gestionar sitios web </h1>

<div style="margin-bottom: 1.5em">
    <a class="btn btn-primary" href="/crear-sitio" role="button">Añadir nuevo sitio web</a>
</div>

<div style="margin-bottom: 1.5em">
    <form method="GET" action="{{ action('SitioController@gestionarSitios') }}">
            <label for="nombre" >Buscar Sitio Web:  </label>
            <input type="text" id ="nombre" name="nombre" value="" required autofocus>
            {{ csrf_field() }}
    </form>
</div>

@if( count($paginas) !== 0)
<table style>
    <tr>
        <th>URL</th>
    </tr>
    @foreach ($paginas as $pagina)
        <tr>
            <td> <a href="/modificar-pagina/{{$pagina['id']}}">{{$pagina->URL}}</a></td>
            
        </tr>
    @endforeach
</table>
<div>
    {{ $paginas->links() }}
</div>
@else
<p style="text-align: center"> El sitio web no tiene ninguna página web asignada.</p>
@endif

@endsection