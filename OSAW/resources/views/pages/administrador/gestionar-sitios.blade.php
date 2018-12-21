@extends('layouts.master')

@section('titulo', 'Gestionar sitios web')

@section('content')

<h1 class="h1-encabezado"> Gestionar sitios web </h1>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div style="margin-bottom: 1.5em">
                <div class="row justify-content-center">
                    <a class="btn btn-primary" href="/crear-sitio" role="button">Añadir nuevo sitio web</a>
                </div>
            </div>

            <div style="margin-bottom: 1.5em">
                <div class="row justify-content-center">
                    <form method="GET" action="{{ action('SitioController@gestionarSitios') }}">
                            <label for="nombre" >Buscar Sitio Web:  </label>
                            <input type="text" id ="nombre" name="nombre" value="" required autofocus>
                            {{ csrf_field() }}
                    </form>
                </div>
            </div>

            @if( count($sitios) !== 0)
            <table class="table-ancho">
                <tr>
                    <th>Sitio web</th>
                </tr>
                @foreach ($sitios as $sitio)
                    <tr>
                        <td> <a href="/modificar-sitio/{{$sitio['id']}}">{{$sitio->nombre}}</a></td>
                    </tr>
                @endforeach
            </table>

            <div class="row justify-content-center">
                <div class="div-links">
                {{ $sitios->links() }}
                </div>
            </div>
            @else
                <p style="text-align: center"> No se ha encontrado ningún sitio web con el nombre buscado.</p>
            @endif
        </div>
    </div>
</div>
    

@endsection