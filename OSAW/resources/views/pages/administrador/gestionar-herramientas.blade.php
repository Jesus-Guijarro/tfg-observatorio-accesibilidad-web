@extends('layouts.master')

@section('titulo', 'Gestionar herramientas')

@section('content')
<h1 class="h1-titulo"> Gestionar herramientas web </h1>

<div style="margin-bottom: 1.5em">
    <a class="btn btn-primary" href="/crear-herramienta" role="button">Añadir nuevo herramienta web</a>
</div>

@if( count($herramientas) !== 0)
<table style>
    <tr>
        <th>Herramienta de evaluación</th>
        <th>Estado herramienta</th>
    </tr>
    @foreach ($herramientas as $herramienta)
        <tr>
            <td>{{$herramienta->descripcion}}</a></td>
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
        </tr>
    @endforeach
</table>
@else
    <p style="text-align: center"> No hay ninguna herramienta de evaluación</p>
@endif



@endsection