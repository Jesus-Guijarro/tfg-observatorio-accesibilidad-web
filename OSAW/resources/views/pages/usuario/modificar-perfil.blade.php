@extends('layouts.master')

@section('titulo', 'Modificar perfil de usuario')

@section('content')

<h1 class="h1-encabezado"> Modificar perfil de usuario </h1>

<hr>

@if(session()->has('mensaje'))
    <div class="alert alert-success">
        {{ session()->get('mensaje') }}
    </div>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php action('UserController@modificarPerfilUsuario', $usuario->id); ?>" enctype="multipart/form-data">
                    {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre de usuario</label>

                            <div class="col-md-6">
                                <input id="nombre" type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{ $usuario->nombre }}" required autofocus>

                                @if ($errors->has('nombre'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Correo electrónico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $usuario->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="avatar" class="col-md-4 col-form-label text-md-right" class="form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}">Avatar</label>

                            <div class="col-md-6">
                                <input id="avatar" type="file" class="form-control-file" name="avatar">
                                @if ($errors->has('avatar'))
                                    <span>
                                        <strong>{{ $errors->first('avatar') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                            
                        <div class="form-group row">
                            <label for="biografia" class="col-md-4 col-form-label text-md-right">Biografia</label>
                            <div class="col-md-6">
                                <textarea class="form-control" id="biografia"  name="biografia" rows="5" cols="34" >{{$usuario->biografia}}</textarea>
                                @if ($errors->has('biografia'))
                                    <span>
                                        <strong>{{ $errors->first('biografia') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Modificar perfil
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="/perfil/{{Auth::user()->id}}">Volver al perfil</a>
@endsection
