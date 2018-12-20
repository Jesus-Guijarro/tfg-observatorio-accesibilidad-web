@extends('layouts.master')

@section('titulo', 'Cambiar contraseña')

@section('content')
<h1 class="h1-encabezado"> Cambiar contraseña de usuario</h1>

@if(session()->has('mensaje'))
    <div class="alert alert-success">
        {{ session()->get('mensaje') }}
    </div>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php action('UserController@cambiarPassword', $usuario->id); ?>" >
                    {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="old_password" class="col-md-4 col-form-label text-md-right">Antigua contraseña</label>

                            <div class="col-md-6">
                                <input id="old_password" type="password" name="old_password" >

                                @if ($errors->has('old_password'))
                                    <span>
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
                                @endif
                                @if (session('old_password'))
                                    <span>
                                        <strong>{{ session('old_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_password" class="col-md-4 col-form-label text-md-right">Nueva contraseña</label>

                            <div class="col-md-6">
                                <input id="new_password" type="password" name="new_password" >

                                @if ($errors->has('new_password'))
                                    <span>
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="new_password_confirm" class="col-md-4 col-form-label text-md-right">Confirmar nueva contraseña</label>

                            <div class="col-md-6">
                                <input id="new_password_confirm" type="password" name="new_password_confirm">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Cambiar contraseña
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection