@extends('layouts.master')

@section('titulo', 'Panel modificar sitio web')

@section('scripts')
<script>
function mostrarEliminar() {
  var id = document.getElementById("eliminar");
  if (id.style.display === "none") {
    id.style.display = "block";
  } else {
    id.style.display = "none";
  }
}
</script>


@section('content')

<h1 class="h1-titulo"> Modificar sitio web </h1>

<div style="margin-bottom: 1.5em">
<button class="btn btn-danger" onclick="mostrarEliminar()">Eliminar Sitio Web</button>
    <div id="eliminar" style="display: none">
        <p>¿Estás seguro de que quieres eliminar el sitio web: <strong>{{$sitio->nombre}}</strong>? </p>
        <a class="btn btn-primary" href="/eliminar-sitio/{{$sitio['id']}}" role="button">Sí</a>
        <button class="btn" onclick="mostrarEliminar()">No</button>
    </div>
</div>

<p>{{$sitio->nombre}}</p>

@endsection