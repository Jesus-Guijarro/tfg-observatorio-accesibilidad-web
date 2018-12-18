@extends('layouts.master')

@section('titulo', 'Perfil de usuario')

@section('content')
<h1 class="h1-titulo"> Perfil de usuario</h1>

<?php $imagen = Storage::url($usuario->avatar);?>

<img src="{{$imagen}}" alt="Avatar usuario">

<p><strong> Nombre de usuario:  </strong> {{$usuario->nombre}} </p>
<p><strong> Correo electrónico: </strong> {{$usuario->email}}</p>
<p><strong>Biografia</strong>  {{$usuario->biografia}}<p>

<div style="margin-bottom: 1.5em">
    <a class="btn btn-primary" href="/modificar-perfil/{{$usuario->id}}" role="button">Editar datos de usuario</a>
</div>










@endsection