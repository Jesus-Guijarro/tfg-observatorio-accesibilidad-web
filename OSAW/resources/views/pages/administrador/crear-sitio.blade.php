@extends('layouts.master')

@section('titulo', 'Crear sitio web')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="form-group row">
        <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre sitio web</label>

        <div class="col-md-6">
            <input id="nombre" type="text"  name="nombre" value="{{ old('nombre') }}" required autofocus>

            @if ($errors->has('nombre'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('nombre') }}</strong>
                </span>
            @endif
        </div>
    </div>


    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                Añadir sitio web
            </button>
            <a class="btn btn-default" href="/gestionar-sitios" role="button">Cancelar</a>
            
        </div>
    </div>
</form>
@endsection