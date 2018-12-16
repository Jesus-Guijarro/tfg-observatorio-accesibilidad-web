@extends('layouts.master')

@section('titulo', 'Reporte automático')

@section('content')

<h1> Reporte automático</h1>

<div>
    <a href="{{$reporte}}" download="{{$reporte}}">Descargar reporte</a>
</div>

<iframe src="{{URL::to('/')}}{{$reporte}}" width="100%" height="100%" ></iframe>


@endsection