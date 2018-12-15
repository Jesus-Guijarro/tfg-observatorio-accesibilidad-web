@extends('layouts.master')

@section('titulo', 'Sitio Web')
@section('scripts')

<script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de la evaluación');
        
        data.addColumn('number', 'Número de problemas de nivel A');
        data.addColumn('number', 'Número de problemas de nivel AA');
        data.addColumn('number', 'Número de problemas de nivel AAA');
        data.addColumn('number', 'Número de advertencias de nivel A');
        data.addColumn('number', 'Número de advertencias de nivel AA');
        data.addColumn('number', 'Número de advertencias de nivel AAA');
        

        data.addRows([
        @foreach ($accessmonitors as $accessmonitor)
            [new Date('{{$accessmonitor->fecha_test}}'),
            {{$accessmonitor->num_problemas_a}},
            {{$accessmonitor->num_problemas_aa}},
            {{$accessmonitor->num_problemas_aaa}},
            {{$accessmonitor->num_advertencias_a}},
            {{$accessmonitor->num_advertencias_aa}},
            {{$accessmonitor->num_advertencias_aaa}}],
        @endforeach
      ]);

      var options = {
          title: 'AccessMonitor'
      };

      var chart = new google.charts.Line(document.getElementById('accessmonitor'));

      chart.draw(data, options);
    }
  </script>

@endsection


@section('content')


@if (in_array(1,$herramientas))
<h3> AccessMonitor</h3>
<div id="accessmonitor" style="width: 900px; height: 500px;"></div>
@endif

@if (in_array(2,$herramientas))
<h3> Achecker </h3>
<div id="achecker" style="width: 900px; height: 500px;"></div>
@endif

@if (in_array(3,$herramientas))
<h3> EIII Page Checker </h3>
<div id="eiiichecker" style="width: 900px; height: 500px;"></div>
@endif

@if (in_array(4,$herramientas))
<h3> Observatorio de la UPS de Ecuador </h3>
<div id="observatorio" style="width: 900px; height: 500px;"></div>
@endif

@if (in_array(5,$herramientas))
<h3> Vamolà </h3>
<div id="vamola" style="width: 900px; height: 500px;"></div>
@endif

@if (in_array(6,$herramientas))
<h3> WAVE </h3>
<div id="wave" style="width: 900px; height: 500px;"></div>
@endif

<h1> Sitio Web </h1>
<p style="text-decoration: underline"> <strong>{{$sitio->nombre}} </strong></p>
<p><strong> Dirección web:</strong> <a href="http://{{ $sitio->dominio }}" target="_blank">{{ $sitio->dominio }}</a>
<p><strong>Número de páginas webs evaluadas: </strong> {{$sitio->num_paginas}}</p>

<p><strong>Páginas web del sitio:</strong></p>

@foreach ($paginas as $pagina)
    <ul style="list-style-type: square;">
        <li style="margin-left: 2em;"><a href="/pagina/{{ $pagina->id }}" style="color: black; text-decoration-line: underline">{{$pagina->URL}}</a></li>
</ul>
    @endforeach
<div>
    {{ $paginas->links() }}
</div>

<h2>Datos de horario de la evaluación</h2>
<p><strong>Periodicidad: </strong>{{$sitio->periodicidad}}</p>

@if ($sitio->periodicidad === "Semanal")
<p><strong>Día de la semana: </strong>{{$dia}}</p>
@elseif ($sitio->periodicidad === "Mensual")
<p><strong>Día mensual: </strong>{{$sitio->dia}}</p>
@endif

<p><strong>Hora: </strong>{{$sitio->hora}}</p>

<h2>Resultados de ejecución de las herramientas</h2>



@endsection