@extends('layouts.master')

@section('titulo', 'Listado participantes')

@section('content')
<h1 class="h1-encabezado">Participantes del observatorio </h1>

<hr>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <table class="table" summary="Tabla que muestra los participantes del observatorio">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Biografia</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td> <a href="/perfil/{{$usuario->id}}"> {{$usuario->nombre}}</a></td>

                        @if($usuario->rol_id===1)
                        <td>Colaborador</td>
                        @elseif($usuario->rol_id===2)
                        <td>Experto</td>
                        @endif
                        <td> {{$usuario->biografia}}</td>    
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

@endsection