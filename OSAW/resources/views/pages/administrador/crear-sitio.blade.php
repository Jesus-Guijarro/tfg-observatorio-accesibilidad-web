@extends('layouts.master')

@section('titulo', 'Crear sitio web')

@section('content')
<h1 class="h1-encabezado"> Añadir sitio web </h1>

<hr>

@if(session()->has('mensaje'))
    <div class="alert alert-success">
        {{ session()->get('mensaje') }}
    </div>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ action('SitioController@crearSitio') }}">
                    {{ csrf_field() }}

                        <!--Nombre del sitio -->
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre sitio web:</label>

                            <div class="col-md-8">
                                <input id="nombre" type="text"  name="nombre" placeholder="Renfe" value="{{ old('nombre') }}" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" required autofocus>

                                @if ($errors->has('nombre'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!--Dominio -->
                        <div class="form-group row">
                            <label for="dominio" class="col-md-4 col-form-label text-md-right">Dominio:</label>

                            <div class="col-md-8">
                                <input id="dominio" type="text"  name="dominio" placeholder="www.renfe.com" value="{{ old('dominio') }}"  class="form-control{{ $errors->has('dominio') ? ' is-invalid' : '' }}" required >

                                @if ($errors->has('dominio'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('dominio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!--Categoria institucional -->
                        <div class="form-group row">
                            <label for="categoria" class="col-md-4 col-form-label text-md-right">Categoria:</label>

                            <div class="col-md-8">

                                <select id="categoria" name="categoria">
                                @foreach ($categorias as $categoria)
                                    <option value="{{$categoria->id}}" {{ old('categoria') == $categoria->id ? 'selected' : '' }}>{{$categoria->descripcion}}</option>
                                @endforeach
                                </select>
                                
                                @if ($errors->has('categoria'))
                                    <span>
                                        <strong class="strong-val">{{ $errors->first('categoria') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!--Herramientas -->
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">Herramientas de evaluación:</label>
                            <div class="col-md-6">

                                @foreach ($herramientas as $herramienta)
                                    <label for="{{$herramienta->nombre}}" hidden> Seleccionar herramienta:</label>
                                    <input type="checkbox" id="{{$herramienta->nombre}}" name="{{$herramienta->nombre}}" value="{{$herramienta->id}}"> {{$herramienta->descripcion}}<br>
                                @endforeach
                            </div>
                        </div>

                        <!--Lista de páginas-->
                        <div class="form-group row">
                            <label for="paginas" class="col-md-4 col-form-label text-md-right">Páginas web:</label>

                            <div class="col-md-8">

                                <textarea class="textarea" id="paginas" name="paginas" rows="10" cols="60" placeholder="Una dirección en cada línea: http://www.renfe.com" value="{{ old('paginas') }}" >{{ old('paginas') }}</textarea>
                                @if ($errors->has('paginas'))
                                    <span>
                                        <strong class="strong-val">{{ $errors->first('paginas') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Número de páginas crawler -->
                        <div class="form-group row">
                            <label for="num_paginas" class="col-md-4 col-form-label text-md-right">Número de paginas a añadir con Crawler:</label>

                            <div class="col-md-8">
                                <input id="num_paginas" type="number"  name="num_paginas"  class="form-control{{ $errors->has('num_paginas') ? ' is-invalid' : '' }}" value="0">

                                @if ($errors->has('num_paginas'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('num_paginas') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!--Periodicidad-->
                        <div class="form-group row">
                            <label for="periodicidad" class="col-md-4 col-form-label text-md-right">Periodicidad de la evaluación:</label>

                            <div class="col-md-8">

                                <select id="periodicidad" name="periodicidad">
                                    <option value="Diaria">Diaria</option>
                                    <option value="Semanal">Semanal</option>
                                    <option value="Mensual">Mensual</option>
                                </select>
                                
                                @if ($errors->has('periodicidad'))
                                    <span>
                                        <strong class="strong-val">{{ $errors->first('periodicidad') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!--Dia-->
                        <div class="form-group row">
                            <label for="dia" class="col-md-4 col-form-label text-md-right">Día de la semana o mes:</label>

                            <div class="col-md-8">
                                <input id="dia" type="number" name="dia" value="{{ old('dia') }}"  class="form-control{{ $errors->has('dia') ? ' is-invalid' : '' }}" required >

                                @if ($errors->has('dia'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong >{{ $errors->first('dia') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!--Hora -->
                        <div class="form-group row">
                            <label for="hora" class="col-md-4 col-form-label text-md-right">Hora:</label>

                            <div class="col-md-8">
                                <input id="hora" type="text"  name="hora" placeholder="17:00" value="{{ old('hora') }}"  class="form-control{{ $errors->has('hora') ? ' is-invalid' : '' }}" required >

                                @if ($errors->has('hora'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('hora') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!--Automatización-->
                        <div class="form-group row">
                            <span class="col-md-4 col-form-label text-md-right"></span>
                            <div class="col-md-4">
                                <label for="automatizado" hidden>Automatizar</label>
                                <input type="checkbox" id="automatizado" name="automatizado"> Realizar seguimiento <br>
                            </div>
                        </div>

                        

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Añadir sitio web
                                </button>
                                <a class="btn btn-default" href="/gestionar-sitios" role="button">Cancelar</a>
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection