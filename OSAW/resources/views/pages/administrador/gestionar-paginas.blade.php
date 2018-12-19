@extends('layouts.master')

@section('titulo', 'Gestionar paginas web')

@section('content')

<h1 class="h1-titulo"> Gestionar páginas web </h1>

@if(session()->has('mensaje'))
    <div class="alert alert-success">
        {{ session()->get('mensaje') }}
    </div>
@endif

@if( count($paginas) !== 0)
<table>
    <tr>
        <th>Página Web</th>
    </tr>
    @foreach ($paginas as $pagina)
        <tr>
            <td>{{$pagina->URL}}</td>
            <td> <a href="/modificar-pagina/{{$pagina->id}}">Modificar Página</a></td>  
            <td> <a href="/eliminar-pagina/{{$pagina->id}}">Eliminar Página</a></td>  
        </tr>
    @endforeach
</table>
<div>
    {{ $paginas->links() }}
</div>
@else
<p style="text-align: center"> El sitio web no tiene ninguna página web asignada.</p>
@endif

<div style="margin-bottom: 1.5em">
    <form method="POST" action="<?php action('PaginaController@crearPagina', [$sitio_id])?>">
        <label for="url" >Nueva página web:  </label>
        <input type="text" id ="url" name="url"  required autofocus>
        @if ($errors->has('url'))
            <span>
                <strong class="strong-val">{{ $errors->first('url') }}</strong>
            </span>
        @endif

            <button type="submit" class="btn btn-primary">
               Añadir
            </button>
        {{ csrf_field() }}
    </form>
</div>

<a href="/modificar-sitio/{{$sitio_id}}">Volver a modificar sitio</a></td>  
@endsection