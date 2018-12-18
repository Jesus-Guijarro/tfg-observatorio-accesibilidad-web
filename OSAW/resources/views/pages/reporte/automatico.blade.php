@extends('layouts.master')

@section('titulo', 'Reporte automático')

@section('content')

<h1> Reporte automático</h1>

<hr>

<div>
   <p><strong>Reporte: </strong><a href="{{$reporte}}" download="{{$reporte}}">{{$reporte}}</a></p>
</div>

<?php $contenido= Storage::get($reporte);?>

<hr>
<pre>{{$contenido}}</pre>




@endsection