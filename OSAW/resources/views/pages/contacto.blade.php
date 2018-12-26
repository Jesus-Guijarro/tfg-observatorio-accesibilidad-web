@extends('layouts.master')

@section('titulo', 'Contacto')

@section('content')

<h1 class="h1-encabezado"> Contacto </h1>

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
                    <form method="POST" action="<?php action('ContactoController@realizarContacto'); ?>">
                    {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Correo electrónico:</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{  old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span >
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="asunto" class="col-md-4 col-form-label text-md-right">Asunto:</label>

                            <div class="col-md-6">
                                <input id="asunto" type="text" class="form-control{{ $errors->has('asunto') ? ' is-invalid' : '' }}" name="asunto" value="{{ old('asunto')}}" required autofocus>

                                @if ($errors->has('asunto'))
                                    <span >
                                        <strong>{{ $errors->first('asunto') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mensaje" class="col-md-4 col-form-label text-md-right">Mensaje:</label>
                            <div class="col-md-6">
                                <textarea id="mensaje" class="form-control"  name="mensaje" rows="15" cols="40" required>{{ old('mensaje')}}</textarea>
                                @if ($errors->has('mensaje'))
                                    <span>
                                        <strong>{{ $errors->first('mensaje') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Realizar contacto
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