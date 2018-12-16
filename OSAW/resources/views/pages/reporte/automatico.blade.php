@extends('layouts.master')

@section('titulo', 'Reporte automático')

@section('content')

<h1> Reporte automático</h1>

<hr>

<div>
   <p><strong>Descargar reporte: </strong><a href="{{$reporte}}" download="{{$reporte}}">{{$nombre_reporte}}</a></p>
</div>

<?php $contenido = File::get(storage_path('app/public/' . $reporte));?>

<hr>
<pre>{{$contenido}}</pre>




@endsection