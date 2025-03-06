@extends('layouts.master')

@section('titulo', 'Modificar sitio web')

@section('content')

<h1 class="h1-encabezado"> Modificar sitio web </h1>

<hr>

@if(session()->has('mensaje'))
    <div class="alert alert-success">
        {{ session()->get('mensaje') }}
    </div>
@endif


<div class="container">
    <div class="row justify-content-center">
            <a class="btn btn-primary" href="/gestionar-paginas/{{$sitio['id']}}" role="button">Gestionar páginas del sitio</a>
        </div>
</div>

<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php action('SitioController@modificarSitio', [$sitio['id']]) ?>">
                        {{ csrf_field() }}

                        <!--Nombre del sitio -->
                        <div class="form-group row">
                            <label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre sitio web</label>

                            <div class="col-md-8">
                                <input id="nombre" type="text"  name="nombre" placeholder="Renfe" value="{{ $sitio->nombre }}" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}"  required autofocus>

                                @if ($errors->has('nombre'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="strong-val">{{ $errors->first('nombre') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!--Dominio -->
                        <div class="form-group row">
                            <label for="dominio" class="col-md-4 col-form-label text-md-right">Dominio</label>

                            <div class="col-md-8">
                                <input id="dominio" type="text"  name="dominio" placeholder="www.renfe.com" value="{{ $sitio->dominio }}" class="form-control{{ $errors->has('dominio') ? ' is-invalid' : '' }}" required >

                                @if ($errors->has('dominio'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="strong-val">{{ $errors->first('dominio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!--Categoria institucional -->
                        <div class="form-group row">
                            <label for="categoria" class="col-md-4 col-form-label text-md-right">Categoria</label>

                            <div class="col-md-8">

                                <select id="categoria" name="categoria">
                                @foreach ($categorias as $categoria)
                                @if($categoria->id === $sitio->categoria_id)
                                    <option value="{{$categoria->id}}" selected="selected">{{$categoria->descripcion}}</option>
                                @else
                                    <option value="{{$categoria->id}}">{{$categoria->descripcion}}</option>
                                @endif
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
                            <label class="col-md-4 col-form-label text-md-right">Herramientas de evaluación</label>
                            <div class="col-md-4">

                                @foreach ($herramientas as $herramienta)
                                    <label for="{{$herramienta->nombre}}" hidden>Seleccionar herramienta</label>
                                    @if (in_array($herramienta->id,$herramientas_sitio))
                                        <input type='hidden' id="{{$herramienta->nombre}}" name="{{$herramienta->nombre}}" value="H:{{$herramienta->id}}"> 
                                        <input type="checkbox" id="{{$herramienta->nombre}}" name="{{$herramienta->nombre}}" value="{{$herramienta->id}}" checked> {{$herramienta->descripcion}}<br>
                                    @else
                                        <input type='hidden' id="{{$herramienta->nombre}}" name="{{$herramienta->nombre}}" value="H:{{$herramienta->id}}"> 
                                        <input type="checkbox" id="{{$herramienta->nombre}}" name="{{$herramienta->nombre}}" value="{{$herramienta->id}}"> {{$herramienta->descripcion}}<br>
                                        
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <!--Añadir páginas-->
                        <div class="form-group row">
                            <label for="paginas" class="col-md-4 col-form-label text-md-right">Añadir páginas web</label>

                            <div class="col-md-8">
                                <textarea class="textarea" id="paginas" name="paginas" rows="10" cols="47" placeholder="Una dirección en cada línea: http://www.renfe.com" >{{ old('paginas') }}</textarea>
                                @if ($errors->has('paginas'))
                                    <span>
                                        <strong class="strong-val">{{ $errors->first('paginas') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Número de páginas crawler -->
                        <div class="form-group row">
                            <label for="num_paginas" class="col-md-4 col-form-label text-md-right">Número de paginas a añadir con Crawler</label>

                            <div class="col-md-8">
                                <input id="num_paginas" type="number"  name="num_paginas" value="0" class="form-control{{ $errors->has('num_paginas') ? ' is-invalid' : '' }}">

                                @if ($errors->has('num_paginas'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="strong-val">{{ $errors->first('num_paginas') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!--Periodicidad-->
                        <div class="form-group row">
                            <label for="periodicidad" class="col-md-4 col-form-label text-md-right">Periodicidad de la evaluación</label>
                            <div class="col-md-8">
                                <select id="periodicidad" name="periodicidad">
                                @if($sitio->periodicidad === "Diaria")
                                    <option value="Diaria" selected="selected">Diaria</option>
                                @else
                                    <option value="Diaria" >Diaria</option>
                                @endif
                                @if($sitio->periodicidad === "Semanal")
                                    <option value="Semanal" selected="selected">Semanal</option>
                                @else
                                    <option value="Semanal">Semanal</option>
                                @endif
                                @if($sitio->periodicidad === "Mensual")
                                    <option value="Mensual" selected="selected">Mensual</option>
                                @else
                                    <option value="Mensual">Mensual</option>
                                @endif
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
                            <label for="dia" class="col-md-4 col-form-label text-md-right">Día de la semana/mes</label>

                            <div class="col-md-8">
                                <input id="dia" type="number"  name="dia" value="{{ $sitio->dia }}" class="form-control{{ $errors->has('dia') ? ' is-invalid' : '' }}" required >

                                @if ($errors->has('dia'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="strong-val">{{ $errors->first('dia') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!--Hora -->
                        <div class="form-group row">
                            <label for="hora" class="col-md-4 col-form-label text-md-right">Hora</label>

                            <div class="col-md-8">
                                <input id="hora" type="text"  name="hora" placeholder="hh:mm" value="{{ $sitio->hora }}" class="form-control{{ $errors->has('hora') ? ' is-invalid' : '' }}" required >

                                @if ($errors->has('hora'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong class="strong-val">{{ $errors->first('hora') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <!--Automatización-->
                        <div class="form-group row">
                            <span class="col-md-4 col-form-label text-md-right"></span>
                            <div class="col-md-4">
                            <label for="automatizado" hidden>Automatizar</label>
                                @if($sitio->automatizado==true)
                                    <input type="checkbox" id="automatizado" name="automatizado" checked> Realizar seguimiento <br>
                                @else
                                    <input type="checkbox" id="automatizado" name="automatizado"> Realizar seguimiento <br>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Modificar sitio web
                                </button>
                                <a class="btn btn-default" href="/gestionar-sitios" role="button">Cancelar</a>     
                            </div>
                        </div>
                    </form>


                <!--Eliminar Sitio-->
                    <div class="row justify-content-center" style="margin-top: 2em">
                        <button class="btn btn-danger" data-toggle="collapse" data-target="#eliminar">Eliminar Sitio Web</button>
                    </div>
                    <div class="row justify-content-center" style="margin-top: 2em">
                        <div id="eliminar" class="collapse">
                            <p>¿Estás seguro de eliminar el sitio web: <strong>{{$sitio->nombre}}</strong>? </p>
                            <div class="row justify-content-center" style="margin-top: 0.5em">
                                <a class="btn btn-primary" href="/eliminar-sitio/{{$sitio['id']}}" role="button" style="margin-right: 4em;">Sí</a>
                                <button class="btn btn-primary" data-toggle="collapse" data-target="#eliminar">No</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a href="/gestionar-sitios">Volver a gestionar sitios</a></td>  

@endsection