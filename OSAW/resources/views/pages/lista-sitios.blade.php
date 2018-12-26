@extends('layouts.master')

@section('titulo', 'Listado-sitios')

@section('content')
    
    <h1 class="h1-encabezado"> Listado de sitios webs evaluados</h1>
    <hr>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div style="margin-bottom: 1.5em">
                    <div class="row justify-content-center">
                        <form method="POST" action="<?php action('SitioController@listarSitiosPorCategoria') ?>">
                            {{ csrf_field() }}
                                <label for="categoria" >Categoria Institucional:  </label>
                                <select id="categoria" name="categoria">
                                    @foreach ($categorias as $cat)
                                    @if(!empty($categoria))
                                            @if($cat->id===$categoria->id)
                                                <option value="{{$cat->id}}" selected>{{$cat->descripcion}}</option>
                                            @else
                                                <option value="{{$cat->id}}" >{{$cat->descripcion}}</option>
                                            @endif
                                        @else
                                            <option value="{{$cat->id}}" >{{$cat->descripcion}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            <button type="submit" class="btn btn-primary">
                                Filtrar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
                @isset ($categoria)
                <h2> {{$categoria->descripcion}}</h2>
                @endisset
                <table class="table" summary="Tabla que muestra el listado de webs, con su enlace a la web de inicio y la categoria a la que pertenece">
                  <caption>Listado de sitios webs</caption> 
                  <thead>
                    <tr>
                        <th>Sitio web</th>
                        <th>URL</th>
                        <th>Categoria Institucional</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($sitios as $sitio)
                        <tr>
                            <td > <a href="/sitio/{{ $sitio->id }}" >{{$sitio->nombre}}</a></td>
                            <td > <a href="http://{{ $sitio->dominio }}" target="_blank">{{$sitio->dominio}}</a></td>
                            <td> {{$sitio->descripcion}}</td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="row justify-content-center">
                    <div class="div-links">
                        {{ $sitios->links() }}
                    </div>
                </div>
        </div>
    </div>


@endsection