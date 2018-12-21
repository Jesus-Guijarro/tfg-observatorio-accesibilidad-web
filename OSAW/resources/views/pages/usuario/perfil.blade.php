@extends('layouts.master')

@section('titulo', 'Perfil de usuario')

@section('content')
@if(Auth::user()->rol_id===3)
<h1 class="h1-encabezado"> Perfil de administrador</h1>
@else
<h1 class="h1-encabezado"> Perfil de usuario</h1>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <img src="/storage/{{$usuario->avatar}}" alt="Avatar usuario {{$usuario->nombre}}">

            @if(Auth::user()->rol_id===1)
            <p><strong>ROL COLABORADOR</strong></p>

            @elseif(Auth::user()->rol_id===2)
            <p><strong>ROL EXPERTO</strong></p>

            @elseif(Auth::user()->rol_id===3)
            <p><strong>ROL ADMINISTRADOR</strong></p>

            @endif

            <p><strong> Nombre de usuario:  </strong> {{$usuario->nombre}} </p>
            <p><strong> Correo electrónico: </strong> {{$usuario->email}}</p>
            <p><strong>Biografia</strong>  {{$usuario->biografia}}<p>

            <div style="margin-bottom: 1.5em">
                <a class="btn btn-primary" href="/modificar-perfil/{{$usuario->id}}" role="button">Editar datos de usuario</a>
            </div>
            <div style="margin-bottom: 1.5em">
                <a class="btn btn-primary" href="/cambiar-password/{{$usuario->id}}" role="button">Cambiar contraseña</a>
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->rol_id===3)

<hr>

<h2 class="h2-perfil-usuario"> Opciones de administración</h2>
<div class="container">
    <div class="row justify-content-center">
            <a class="btn btn-info" href="/gestionar-sitios" role="button">Gestionar sitios web</a>
            <a class="btn btn-info" href="/gestionar-herramientas" role="button" style="margin-left: 5em">Gestionar herramientas de evaluación</a>
    </div>
</div>

@endif









@endsection