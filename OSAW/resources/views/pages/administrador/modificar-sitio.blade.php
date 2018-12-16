@extends('layouts.master')

@section('titulo', 'Panel modificar sitio web')

@section('content')

<h1 class="h1-titulo"> Modificar sitio web </h1>

<div style="margin-bottom: 1.5em">
    <a class="btn btn-danger" href="/eliminar-sitio/{{$sitio['id']}}" role="button">Eliminar Sitio Web</a>
</div>

<p>{{$sitio->nombre}}</p>

@endsection