@extends('layouts.master')

@section('titulo', 'Reporte automático')

@section('content')

<h1 class="h1-encabezado"> Reporte automático</h1>

<hr>
<div class="container">
    <div class="col-md-11">

      <a class="btn btn-primary" href="/storage{{$reporte}}" download="{{$reporte}}" role="button">Descargar reporte</a>

      <?php $contenido= Storage::get($reporte);?>

      <hr>
      <pre>{{$contenido}}</pre>

      <hr>
   </div>
</div>
<a href="{{ URL::previous() }}">Volver a la página web</a></td>  
@endsection