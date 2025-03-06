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

            @if($usuario->rol_id===1)
            <h2>COLABORADOR</h2>

            @elseif($usuario->rol_id===2)
            <h2>EXPERTO</h2>

            @elseif($usuario->rol_id===3)
            <h2>ADMINISTRADOR</h2>

            @endif

            <p><strong> Nombre de usuario:  </strong> {{$usuario->nombre}} </p>
            <p><strong> Correo electrónico: </strong> {{$usuario->email}}</p>
            <p><strong>Biografía:</strong></p> 
            <label for="biografia" hidden>Biografia:</label> 
            <textarea id="biografia" name="biografia" cols="35" rows="7" readonly> {{$usuario->biografia}}</textarea>

            
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
            <p><a href="/logs">Ver archivos de registro de las evaluaciones</a></p>
        </div> 
    </div> 
</div>   



@endif









@endsection