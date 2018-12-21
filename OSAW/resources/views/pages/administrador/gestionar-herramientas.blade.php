@extends('layouts.master')

@section('titulo', 'Gestionar herramientas')

@section('content')
<h1 class="h1-encabezado"> Gestionar herramientas de evaluación </h1>

@if(session()->has('mensaje'))
    <div class="alert alert-success">
        {{ session()->get('mensaje') }}
    </div>
@endif

@if( count($herramientas) !== 0)
<table class="table-ancho" summary="Tabla que muestra las herramientas de evaluación que hace uso el observatorio">
    <thead>
        <tr>
            <th>Herramienta de evaluación</th>
            <th>Nombre</th>
            <th>Estado herramienta</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($herramientas as $herramienta)
        <tr>
            <td> {{$herramienta->descripcion}}</td>
            <td> {{$herramienta->nombre}}</td>
            
            @if ($herramienta->activa===1)
                <td>Activa</td>
                    <?php 
                        $url = action('HerramientaController@desactivarHerramienta',$herramienta->id);  
                    ?>
                <td><a href="{{$url}}">Desactivar herramienta</a></td>
            @else
                <td>No activa</td>
                <?php 
                        $url = action('HerramientaController@activarHerramienta',$herramienta->id);  
                ?>
                <td><a href="{{$url}}">Activar herramienta</a></td>
            @endif
                <td> <a href="modificar-herramienta/{{$herramienta->id}}">Modificar</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
@else
    <p style="text-align: center"> No hay ninguna herramienta de evaluación</p>
@endif
<div class="row justify-content-center">
    <div style="margin-bottom: 1.5em">
        <a class="btn btn-primary" href="/crear-herramienta" role="button">Añadir nueva herramienta web</a>
    </div>
</div>

@endsection