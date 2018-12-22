@extends('layouts.master')

@section('titulo', 'Reporte automático')

@section('content')

<h1 class="h1-encabezado"> Reporte automático</h1>

<hr>

<div>
   <p><strong>Reporte: </strong><a href="/storage{{$reporte}}" download="{{$reporte}}">{{$reporte}}</a></p>
</div>

<?php $contenido= Storage::get($reporte);?>

<hr>
<pre>{{$contenido}}</pre>

<hr>

<a href="{{ URL::previous() }}">Volver a la página web</a></td>  
@endsection