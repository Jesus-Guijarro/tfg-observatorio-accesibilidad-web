@extends('layouts.master')

@section('titulo', 'Sitio Web')
@section('scripts')

<script>
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart1);
function drawChart1() {
    var data = google.visualization.arrayToDataTable
        ([['X', '1', '2', '3', '4', '5', '6'],
            [1, 2, 3, 4, 5, 6, 7],
            [2, 3, 4, 5, 6, 7, 8],
            [3, 4, 5, 6, 7, 8, 9],
            [4, 5, 6, 7, 20, 9, 10],
            [5, 6, 7, 8, 9, 10, 11],
            [6, 7, 8, 9, 10, 11, 12]
    ]);

    var options = {
        legend: 'none',
        series: {
        0: { color: '#e2431e' },
        1: { color: '#e7711b' },
        2: { color: '#f1ca3a' },
        3: { color: '#6f9654' },
        4: { color: '#1c91c0' },
        5: { color: '#43459d' },
        }
    };

    var chart = new google.visualization.LineChart(document.getElementById('accessmonitor'));
    chart.draw(data, options);
}

google.charts.setOnLoadCallback(drawChart2);

function drawChart2() {
    var data = google.visualization.arrayToDataTable
    ([['X', '1', '2', '3', '4', '5', '6'],
        [1, 2, 3, 4, 5, 6, 7],
        [2, 3, 4, 5, 6, 7, 8],
        [3, 4, 5, 6, 7, 8, 9],
        [4, 5, 6, 7, 20, 9, 10],
        [5, 6, 7, 8, 9, 10, 11],
]);

var options = {
    legend: 'none',
    series: {
    0: { color: '#e2431e' },
    1: { color: '#e7711b' },
    2: { color: '#f1ca3a' },
    3: { color: '#6f9654' },
    4: { color: '#1c91c0' },
    }
};
    var chart = new google.visualization.LineChart(document.getElementById('wave'));
    chart.draw(data, options);
}

console.log("{{$sitio->nombre}}")

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

<h3> AccessMonitor</h3>
<div id="accessmonitor" style="width: 900px; height: 500px;"></div>

<h3> Achecker </h3>
<div id="achecker" style="width: 900px; height: 500px;"></div>

<h3> EIII Page Checker </h3>
<div id="eiiichecker" style="width: 900px; height: 500px;"></div>

<h3> Observatorio de la UPS de Ecuador </h3>
<div id="observatorio" style="width: 900px; height: 500px;"></div>

<h3> Vamolà </h3>
<div id="vamola" style="width: 900px; height: 500px;"></div>

<h3> WAVE </h3>
<div id="wave" style="width: 900px; height: 500px;"></div>


<div class="container">
    Sitio -> {{$sitio->nombre}}
</div>
@endsection