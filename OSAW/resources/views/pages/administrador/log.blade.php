@extends('layouts.master')

@section('titulo', 'Log')

@section('content')

<h1 class="h1-encabezado"> Log</h1>

<hr>

<p><strong>Tipo: </strong>{{$tipo}}</p>
<p><strong>Fecha: </strong>{{$fecha}}</p>

<?php $contenido= Storage::get($log);?>

<hr>
<pre>{{$contenido}}</pre>

<hr>

<a href="{{ URL::previous() }}">Volver</a></td>  
@endsection