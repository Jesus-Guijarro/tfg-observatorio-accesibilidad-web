@extends('layouts.master')

@section('titulo', 'Gestionar paginas web')

@section('content')

<h1 class="h1-titulo"> Gestionar páginas web </h1>

<div style="margin-bottom: 1.5em">
    <form method="GET" action="<?php action('PaginaController@gestionarPaginas', [$sitio_id]) ?>">
            <label for="url" >Buscar Pagina Web:  </label>
            <input type="text" id ="url" name="url" value="" required autofocus>
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
            <!--<td > <input id="url" style="width: 100%" type="text"  name="url" value="{{ $pagina->URL }}" required></td>-->
            <td> <a href="/modificar-pagina/{{$pagina['id']}}">Modificar Página</a></td>
            <td> <a href="/eliminar-pagina/{{$pagina['id']}}">Eliminar Página</a></td>  
        </tr>
    @endforeach
</table>
<div>
    {{ $paginas->links() }}
</div>
@else
<p style="text-align: center"> El sitio web no tiene ninguna página web asignada.</p>
@endif

@if(session()->has('mensaje'))
    <div class="alert alert-success">
        {{ session()->get('mensaje') }}
    </div>
@endif

<div style="margin-bottom: 1.5em">
    <form method="POST" action="<?php action('PaginaController@crearPagina', [$sitio_id])?>">
        <label for="url" >Nueva página web:  </label>
        <input type="text" id ="url" name="url"  required autofocus>

            <button type="submit" class="btn btn-primary">
               Añadir
            </button>
        {{ csrf_field() }}
    </form>
</div>

@endsection