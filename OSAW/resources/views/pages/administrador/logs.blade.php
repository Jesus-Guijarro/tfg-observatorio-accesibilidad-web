@extends('layouts.master')

@section('titulo', 'Reporte automático')



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

function getLog(){
   var log = document.getElementById("log");
}
</script>

@endsection

@section('content')

<h1 class="h1-encabezado"> Logs</h1>

<hr>
<label for="tipo_log">Tipo de log:</label>
<select id="tipo_log" name="tipo_log" onchange="getListaLogs()"> 
  <option value="paginas">Logs de las páginas web</option> 
  <option value="herramientas">Logs de las herramientas</option> 
</select> 

<div id="paginas" style="display: none;">
<label for="log_pagina">Log de errores de página :</label>
<select id="log_pagina" name="tipo_log" onchange="getLog()"> 
@foreach($logs_herramientas as $l)
   <?php 
      $texto_opcion = str_replace("logs/herramientas/log_herramientas_","","$l"); 
      $texto_opcion = str_replace(".log","","$texto_opcion"); 
   ?>
<option value="{{$l}}"> Fecha - {{$texto_opcion}}</option> 
@endforeach
</select> 
</div>

<div id="herramientas" style="display: none;">
<label for="log_herramienta">Log de errores de herramientas:</label>
<select id="log_herramienta" name="log_herramienta" onchange="getLog()"> 
@foreach($logs_paginas as $l)log_herramientas_2018-12-11
   <?php 
      $texto_opcion = str_replace("logs/paginas/log_paginas_","","$l");
      $texto_opcion = str_replace(".log","","$texto_opcion");  
   ?>
  <option value="{{$l}}"> Fecha - {{$texto_opcion}}</option> 
@endforeach
</select> 
</div>


<div id="log"



@endsection