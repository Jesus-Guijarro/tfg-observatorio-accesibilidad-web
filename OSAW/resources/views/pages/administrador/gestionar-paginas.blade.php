@extends('layouts.master')

@section('titulo', 'Gestionar paginas web')

@section('content')

<h1 class="h1-encabezado"> Gestionar páginas web </h1>

<hr>

@if(session()->has('mensaje'))
    <div class="alert alert-success">
        {{ session()->get('mensaje') }}
    </div>
@endif

<div class="row justify-content-center">
    <div style="margin-bottom: 1.5em">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="<?php action('PaginaController@crearPagina', [$sitio_id])?>">
                {{ csrf_field() }}
                        <label for="url">Añadir nueva página web al sitio:  </label>
                        <input type="text" id ="url" name="url" required autofocus>
                        @if ($errors->has('url'))
                            <span>
                                <strong class="strong-val">{{ $errors->first('url') }}</strong>
                            </span>
                        @endif
                        <button type="submit" class="btn btn-primary">
                            Añadir
                        </button>
                </form>
            </div>
        </div>
    </div>
</div>

@if( count($paginas) !== 0)
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div style="margin-bottom: 1.5em">
                <div class="row justify-content-center">
                    <table summary="Lista de páginas web del sitio web a gestionar">
                        <thead>
                            <tr>
                                <th>Página Web</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($paginas as $pagina)
                            <tr>
                                <td>{{$pagina->URL}}</td>
                                <td > <a href="/modificar-pagina/{{$pagina->id}}">Modificar Página</a></td>  
                                <td > <a class="btn btn-danger" href="/eliminar-pagina/{{$pagina->id}}" role="button">Eliminar Página</a></td>  
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div>
                        {{ $paginas->links() }}
                    </div>
                    @else
                    <p style="text-align: center"> El sitio web no tiene ninguna página web asignada.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<a href="/modificar-sitio/{{$sitio_id}}">Volver a modificar sitio</a></td>  
@endsection