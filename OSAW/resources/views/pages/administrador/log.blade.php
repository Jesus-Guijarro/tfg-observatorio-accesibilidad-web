@extends('layouts.master')

@section('titulo', 'Archivo de registo')

@section('content')

<h1 class="h1-encabezado"> Archivo de registro</h1>

<hr>
<div class="container">
    <div class="col-md-10">
        <p><strong>Tipo: </strong>{{$tipo}}</p>
        <p><strong>Fecha: </strong>{{$fecha}}</p>


        <?php $contenido= Storage::get($log);?>

        <hr>
        <pre>{{$contenido}}</pre>

        <hr>

    </div>
</div>

<a href="{{ URL::previous() }}">Volver</a></td>  
@endsection