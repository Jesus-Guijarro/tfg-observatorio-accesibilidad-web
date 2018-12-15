@extends('layouts.master')

@section('titulo', 'Sitio Web')
@section('scripts')

<script type="text/javascript">
      google.charts.load('current', {'packages':['line']});
      google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = new google.visualization.DataTable();
      data.addColumn('number', 'Day');
      data.addColumn('number', 'Guardians of the Galaxy');
      data.addColumn('number', 'The Avengers');
      data.addColumn('number', 'Transformers: Age of Extinction');

      data.addRows([
        [1,  37.8, 80.8, 41.8],
        [2,  30.9, 69.5, 32.4],
        [3,  25.4,   57, 25.7],
        [4,  11.7, 18.8, 10.5],
        [5,  11.9, 17.6, 10.4],
        [6,   8.8, 13.6,  7.7],
        [7,   7.6, 12.3,  9.6],
        [8,  12.3, 29.2, 10.6],
        [9,  16.9, 42.9, 14.8],
        [10, 12.8, 30.9, 11.6],
        [11,  5.3,  7.9,  4.7],
        [12,  6.6,  8.4,  5.2],
        [13,  4.8,  6.3,  3.6],
        [14,  4.2,  6.2,  3.4]
      ]);

      var options = {
        chart: {
          title: 'AccessMonitor',
          subtitle: 'in millions of dollars (USD)'
        },
        width: 900,
        height: 500,
        axes: {
          x: {
            0: {side: 'top'}
          }
        }
      };

      var chart = new google.charts.Line(document.getElementById('accessmonitor'));

      chart.draw(data, google.charts.Line.convertOptions(options));
    }
  </script>

@endsection


@section('content')

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

@endsection