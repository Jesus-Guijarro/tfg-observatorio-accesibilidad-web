@extends('layouts.master')

@section('titulo', 'Archivos de registo')



@section('scripts')
<script>

function getListaLogs() {
   var selector_tipo=document.getElementById("tipo_log");
   var tipo_log =selector_tipo.options[selector_tipo.selectedIndex].value;

   if (tipo_log =="paginas"){
      document.getElementById('paginas').style.display = "block";
      document.getElementById('herramientas').style.display = "none";
   }
   else if(tipo_log =="herramientas"){
      document.getElementById('herramientas').style.display = "block";
      document.getElementById('paginas').style.display = "none";
   }
}
</script>

@endsection

@section('content')

<h1 class="h1-encabezado"> Archivos de registro</h1>

<hr>

<div class="container">
   <div class="col-md-11">
      <div class="row justify-content-center">
         <div style="margin-right: 2em">
            <label for="tipo_log">Tipo de archivo de registro:</label>
            <select id="tipo_log" name="tipo_log" onclick="getListaLogs()"> 
               <option value="paginas">Archivos de registro de las páginas web</option> 
               <option value="herramientas">Archivos de registro de las herramientas</option> 
            </select> 
         </div>
         <div>
            <table id="paginas" summary="Tabla que muestra los logs páginas que no se han podido evaluar" style="display: none;">
               <thead>
                  <tr>
                     <th>Archivos de registro de páginas</th>
                  </tr>
               </thead>
               <tbody>
               @foreach($logs_paginas as $l)
                  <tr>
                     <?php 
                        $texto_opcion = str_replace("logs/paginas/log_paginas_","","$l"); 
                        $texto_opcion = str_replace(".log","","$texto_opcion"); 
                        $log=str_replace("/","+",$l);
                     ?>
                     <td><a href="/log/{{$log}}" >Fecha - {{$texto_opcion}}</a></td>
                  </tr>
                  @endforeach
               </tbody>
            </table>

            <table id="herramientas" summary="Tabla con los logs de posibles errores de las herramientas de evaluación" style="display: none;">
               <thead>
                  <tr>
                     <th>Archivos de registro de herramientas</th>
                  </tr>
               </thead>
               <tbody>
                  @foreach($logs_herramientas as $l)
                  <tr>
                     <?php 
                        $texto_opcion = str_replace("logs/herramientas/log_herramientas_","","$l"); 
                        $texto_opcion = str_replace(".log","","$texto_opcion"); 
                        $log=str_replace("/","+",$l);
                     ?>
                     <td><a href="/log/{{$log}}" >Fecha - {{$texto_opcion}}</a></td>
                  </tr>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

<a href="/perfil/{{Auth::user()->id}}">Volver a perfil de administrador</a></td>  

@endsection