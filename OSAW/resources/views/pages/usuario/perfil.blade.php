@extends('layouts.master')

@section('titulo', 'Perfil de usuario')

@section('content')
@if(Auth::user()->rol_id===3 and Auth::user()->id===$usuario->id)
<h1 class="h1-encabezado"> Perfil de administrador</h1>
@else
<h1 class="h1-encabezado"> Perfil de usuario</h1>
@endif

<hr>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <img src="/storage/{{$usuario->avatar}}" alt="Avatar usuario {{$usuario->nombre}}" style="border-style: groove; width: 12em; height: 12em">

            @if($usuario->id===1)
            <p style="color:#ff9933"><strong>COLABORADOR</strong></p>

            @elseif($usuario->id===2)
            <p style="color:#64d671"><strong>EXPERTO</strong></p>

            @elseif($usuario->id===3)
            <p style="color:#0066cc"><strong>ADMINISTRADOR</strong></p>

            @endif

            <p><strong> Nombre de usuario:  </strong> {{$usuario->nombre}} </p>
            <p><strong> Correo electrónico: </strong> {{$usuario->email}}</p>
            <p><strong>Biografía:</strong><p> <textarea cols="35" rows="7" readonly> {{$usuario->biografia}}</textarea>

            
            @if(Auth::user()->id===$usuario->id)
            <div style="margin-bottom: 1.5em">
                <a href="/modificar-perfil/{{$usuario->id}}" >Editar datos de usuario</a>
            </div>
            <div style="margin-bottom: 1.5em">
                <a href="/cambiar-password/{{$usuario->id}}" >Cambiar contraseña</a>
            </div>
            @endif
        </div>
    </div>
</div>

@if(Auth::user()->rol_id===3 and Auth::user()->id===$usuario->id)

<hr>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <h2> Opciones de administración</h2>
            <p><a href="/gestionar-sitios">Gestionar sitios web</a></p>
            <p><a href="/gestionar-herramientas" >Gestionar herramientas de evaluación</a></p>
            <p><a href="/gestionar-usuarios" >Gestionar usuarios</a></p>
            <p><a href="/logs">Ver logs de las evaluaciones</a></p>
        </div> 
    </div> 
</div>   



@endif









@endsection