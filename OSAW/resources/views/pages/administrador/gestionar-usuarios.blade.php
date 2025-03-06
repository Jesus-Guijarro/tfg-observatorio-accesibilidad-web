@extends('layouts.master')

@section('titulo', 'Gestionar usuarios')

@section('content')
<h1 class="h1-encabezado"> Gestionar usuarios </h1>

<hr>


@if(session()->has('mensaje'))
    <div class="alert alert-success">
        {{ session()->get('mensaje') }}
    </div>
@endif

<div style="margin-bottom: 1.5em">
    <div class="row justify-content-center">
        <form method="GET" action="{{ action('UserController@gestionarUsuarios') }}">
                <label for="nombre" >Buscar Usuario:  </label>
                <input type="text" id ="nombre" name="nombre" value="" required autofocus>
                {{ csrf_field() }}
        </form>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if( count($usuarios) !== 0)
            <table class="table" summary="Tabla que muestra los participantes del observatorio">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td> <a href="/perfil/{{$usuario->id}}"> {{$usuario->nombre}}</a></td>

                        @if($usuario->rol_id===1)
                        <td>Colaborador</td>
                        <?php 
                            $url = action('UserController@hacerExperto',$usuario->id);  
                        ?>
                        <td><a class="btn btn-primary btn-block" href="{{$url}}" role="button">Hacer Experto</a></td>
                        @elseif($usuario->rol_id===2)
                        <td>Experto</td>
                        <?php 
                                    $url = action('UserController@hacerColaborador',$usuario->id);    
                        ?>
                        <td><a class="btn btn-primary btn-block" href="{{$url}}" role="button">Hacer Colaborador</a></td>
                        @endif
                            
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="div-links">
        {{ $usuarios->links() }}
    </div>
</div>
@else
    <p style="text-align: center"> No hay ningún participante en el observatorio</p>
@endif

<a href="/perfil/{{Auth::user()->id}}">Volver a perfil de administrador</a></td>  

@endsection