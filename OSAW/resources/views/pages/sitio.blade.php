@extends('layouts.master')

@section('titulo', 'Sitio Web')

@section('scripts')
<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});

    /*AccessMonitor*/
    @if (in_array(1,$herramientas) && (count($accessmonitors)>0))
        google.charts.setOnLoadCallback(am_puntuacion);
        google.charts.setOnLoadCallback(am_problemas);
        google.charts.setOnLoadCallback(am_advertencias);
    @endif

    function am_puntuacion() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha la evaluación');
        data.addColumn('number', 'Puntuación');


        data.addRows([
            @foreach ($accessmonitors as $accessmonitor)
                [new Date('{{$accessmonitor->fecha_test}}'),
                {{$accessmonitor->puntuacion}}],
            @endforeach
        ]);

        var options = {
            title: 'AccessMonitor - Puntuación',
            vAxis: { 
                minValue:0,
                maxValue: 10,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('accessmonitor-puntuacion'));

        chart.draw(data, options);
    }

    function am_problemas() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de problemas de nivel A');
        data.addColumn('number', 'Número de problemas de nivel AA');
        data.addColumn('number', 'Número de problemas de nivel AAA');


        data.addRows([
            @foreach ($accessmonitors as $accessmonitor)
                [new Date('{{$accessmonitor->fecha_test}}'),
                {{$accessmonitor->num_problemas_a}},
                {{$accessmonitor->num_problemas_aa}},
                {{$accessmonitor->num_problemas_aaa}}],
            @endforeach
        ]);

        var options = {
            title: 'AccessMonitor - Número de problemas según nivel de conformidad',
            vAxis: { 
                minValue:0,
                maxValue: 5,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff','#ff6600','#009900'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
                1: { pointShape: 'circle' },
                2: { pointShape: 'circle' },
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('accessmonitor-problemas'));

        chart.draw(data, options);
    }

    function am_advertencias() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de advertencias de nivel A');
        data.addColumn('number', 'Número de advertencias de nivel AA');
        data.addColumn('number', 'Número de advertencias de nivel AAA');


        data.addRows([
        @foreach ($accessmonitors as $accessmonitor)
            [new Date('{{$accessmonitor->fecha_test}}'),
            {{$accessmonitor->num_advertencias_a}},
            {{$accessmonitor->num_advertencias_aa}},
            {{$accessmonitor->num_advertencias_aaa}}],
        @endforeach
        ]);

        var options = {
            title: 'AccessMonitor - Número de advertencias según nivel de conformidad',
            vAxis: { 
                minValue:0,
                maxValue: 5,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff','#ff6600','#009900'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
                1: { pointShape: 'circle' },
                2: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('accessmonitor-advertencias'));

        chart.draw(data, options);
    }

    /*Achecker*/
    @if (in_array(2,$herramientas) && (count($acheckers)>0))
        google.charts.setOnLoadCallback(ac_total_conocidos);
        google.charts.setOnLoadCallback(ac_total_potenciales);
        google.charts.setOnLoadCallback(ac_conocidos);
        google.charts.setOnLoadCallback(ac_potenciales);
    @endif

    function ac_total_conocidos() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de problemas conocidos');


        data.addRows([
        @foreach ($acheckers as $achecker)
            [new Date('{{$achecker->fecha_test}}'),
            {{$achecker->num_problemas_conocidos}}],
        @endforeach
        ]);

        var options = {
            title: 'AChecker - Número de problemas conocidos',
            vAxis: { 
                minValue:0,
                maxValue: 5,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('achecker-total-conocidos'));

        chart.draw(data, options);
    }

    function ac_total_potenciales() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de problemas potenciales');


        data.addRows([
        @foreach ($acheckers as $achecker)
            [new Date('{{$achecker->fecha_test}}'),
            {{$achecker->num_problemas_potenciales}}],
        @endforeach
        ]);

        var options = {
            title: 'AChecker - Número de problemas potenciales',
            vAxis: { 
                minValue:0,
                maxValue: 5,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('achecker-total-potenciales'));

        chart.draw(data, options);
    }

    function ac_conocidos() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de criterios con problemas conocidos de nivel A');
        data.addColumn('number', 'Número de criterios con problemas conocidos de nivel AA');
        data.addColumn('number', 'Número de criterios con problemas conocidos de nivel AAA');


        data.addRows([
        @foreach ($acheckers as $achecker)
            [new Date('{{$achecker->fecha_test}}'),
            {{$achecker->num_problemas_conocidos_a}},
            {{$achecker->num_problemas_conocidos_aa}},
            {{$achecker->num_problemas_conocidos_aaa}}],
        @endforeach
        ]);

        var options = {
            title: 'AChecker - Número de criterios con problemas conocidos  según nivel de conformidad',
            vAxis: { 
                minValue:0,
                maxValue: 5,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff','#ff6600','#009900'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
                1: { pointShape: 'circle' },
                2: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('achecker-conocidos'));

        chart.draw(data, options);
    }

    function ac_potenciales() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de criterios con problemas potenciales de nivel A');
        data.addColumn('number', 'Número de criterios con problemas potenciales de nivel AA');
        data.addColumn('number', 'Número de criterios con problemas potenciales de nivel AAA');


        data.addRows([
        @foreach ($acheckers as $achecker)
            [new Date('{{$achecker->fecha_test}}'),
            {{$achecker->num_problemas_potenciales_a}},
            {{$achecker->num_problemas_potenciales_aa}},
            {{$achecker->num_problemas_potenciales_aaa}}],
        @endforeach
        ]);

        var options = {
            title: 'AChecker - Número de criterios con problemas potenciales según nivel de conformidad',
            vAxis: { 
                minValue:0,
                maxValue: 5,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff','#ff6600','#009900'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
                1: { pointShape: 'circle' },
                2: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('achecker-potenciales'));

        chart.draw(data, options);
    }

    /*EIIIChecker*/
    @if (in_array(3,$herramientas) && (count($eiiicheckers)>0))
        google.charts.setOnLoadCallback(ei_puntuacion);
        google.charts.setOnLoadCallback(ei_total);
        google.charts.setOnLoadCallback(ei_problemas);
    @endif

    function ei_puntuacion() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Puntuación');


        data.addRows([
        @foreach ($eiiicheckers as $eiiichecker)
            [new Date('{{$eiiichecker->fecha_test}}'),
            {{$eiiichecker->puntuacion}}],
        @endforeach
        ]);

        var options = {
            title: 'EIII Page Checker - Puntuación(%)',
            vAxis: { 
                minValue:0,
                maxValue: 100,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('eiiichecker-puntuacion'));

        chart.draw(data, options);
    }

    function ei_total() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de problemas');
        data.addColumn('number', 'Número de aciertos');

        data.addRows([
        @foreach ($eiiicheckers as $eiiichecker)
            [new Date('{{$eiiichecker->fecha_test}}'),
            {{$eiiichecker->num_problemas}},
            {{$eiiichecker->num_aciertos}}],
        @endforeach
        ]);

        var options = {
            title: 'EIII Page Checker - Número de problemas y aciertos',
            vAxis: { 
                minValue:0,
                maxValue: 5,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff','#ff6600'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
                1: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('eiiichecker-total'));

        chart.draw(data, options);
    }

    function ei_problemas() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de problemas de nivel de conformidad A');
        data.addColumn('number', 'Número de problemas de nivel de conformidad AA');

        data.addRows([
        @foreach ($eiiicheckers as $eiiichecker)
            [new Date('{{$eiiichecker->fecha_test}}'),
            {{$eiiichecker->num_problemas_a}},
            {{$eiiichecker->num_problemas_aa}}],
        @endforeach
        ]);

        var options = {
            title: 'EIII Page Checker - Número de problemas según su nivel de conformidad',
            vAxis: { 
                minValue:0,
                maxValue: 5,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff','#ff6600'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
                1: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('eiiichecker-problemas'));

        chart.draw(data, options);
    }


    /*Observatorio*/
    @if (in_array(4,$herramientas) && (count($observatorios)>0))
        google.charts.setOnLoadCallback(o_porcentajes);
        google.charts.setOnLoadCallback(o_problemas);
        google.charts.setOnLoadCallback(o_advertencias);
    @endif

    function o_porcentajes() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Porcentaje Comprensible');
        data.addColumn('number', 'Porcentaje Operable');
        data.addColumn('number', 'Porcentaje Perceptible');
        data.addColumn('number', 'Porcentaje Robusto');


        data.addRows([
        @foreach ($observatorios as $observatorio)
            [new Date('{{$observatorio->fecha_test}}'),
            {{$observatorio->porcentaje_comprensible}},
            {{$observatorio->porcentaje_operable}},
            {{$observatorio->porcentaje_perceptible}},
            {{$observatorio->porcentaje_robusto}}],
        @endforeach
        ]);

        var options = {
            title: 'Observatorio Accesibilidad Web de la UPS de Ecuador - Porcentaje cumplido de cada principio de accesibilidad',
            vAxis: { 
                minValue:0,
                maxValue: 5,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff','#ff6600','#009900','#cc33ff'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
                1: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('observatorio-porcentajes'));

        chart.draw(data, options);
    }

    function o_problemas() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de problemas Comprensible');
        data.addColumn('number', 'Número de problemas Operable');
        data.addColumn('number', 'Número de problemas Perceptible');
        data.addColumn('number', 'Número de problemas Robusto');


        data.addRows([
        @foreach ($observatorios as $observatorio)
            [new Date('{{$observatorio->fecha_test}}'),
            {{$observatorio->num_problemas_comprensible}},
            {{$observatorio->num_problemas_operable}},
            {{$observatorio->num_problemas_perceptible}},
            {{$observatorio->num_problemas_robusto}}],
        @endforeach
        ]);

        var options = {
            title: 'Observatorio Accesibilidad Web de la UPS de Ecuador - Número de problemas de cada principio de accesibilidad',
            vAxis: { 
                minValue:0,
                maxValue: 5,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff','#ff6600','#009900','#cc33ff'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
                1: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('observatorio-problemas'));

        chart.draw(data, options);
    }

    function o_advertencias() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de advertencias Comprensible');
        data.addColumn('number', 'Número de advertencias Operable');
        data.addColumn('number', 'Número de advertencias Perceptible');
        data.addColumn('number', 'Número de advertencias Robusto');


        data.addRows([
        @foreach ($observatorios as $observatorio)
            [new Date('{{$observatorio->fecha_test}}'),
            {{$observatorio->num_advertencias_comprensible}},
            {{$observatorio->num_advertencias_operable}},
            {{$observatorio->num_advertencias_perceptible}},
            {{$observatorio->num_advertencias_robusto}}],
        @endforeach
        ]);

        var options = {
            title: 'Observatorio Accesibilidad Web de la UPS de Ecuador - Número de advertencias de cada principio de accesibilidad',
            vAxis: { 
                minValue:0,
                maxValue: 5,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff','#ff6600','#009900','#cc33ff'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
                1: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('observatorio-advertencias'));

        chart.draw(data, options);
    }

    /*Vamola*/
    @if (in_array(5,$herramientas) && (count($vamolas)>0))
        google.charts.setOnLoadCallback(v_total_conocidos);
        google.charts.setOnLoadCallback(v_total_potenciales);
        google.charts.setOnLoadCallback(v_conocidos);
        google.charts.setOnLoadCallback(v_potenciales);
    @endif

    function v_total_conocidos() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de problemas conocidos');


        data.addRows([
        @foreach ($vamolas as $vamola)
            [new Date('{{$vamola->fecha_test}}'),
            {{$vamola->num_problemas_conocidos}}],
        @endforeach
        ]);

        var options = {
            title: 'Vamolà - Número de problemas conocidos',
            vAxis: { 
                minValue:0,
                maxValue: 5,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('vamola-total-conocidos'));

        chart.draw(data, options);
    }

    function v_total_potenciales() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de problemas potenciales');


        data.addRows([
        @foreach ($vamolas as $vamola)
            [new Date('{{$vamola->fecha_test}}'),
            {{$vamola->num_problemas_potenciales}}],
        @endforeach
        ]);

        var options = {
            title: 'Vamolà - Número de problemas potenciales',
            vAxis: { 
                minValue:0,
                maxValue: 5,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('vamola-total-potenciales'));

        chart.draw(data, options);
    }

    function v_conocidos() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de criterios con problemas conocidos de nivel A');
        data.addColumn('number', 'Número de criterios con problemas conocidos de nivel AA');
        data.addColumn('number', 'Número de criterios con problemas conocidos de nivel AAA');


        data.addRows([
        @foreach ($vamolas as $vamola)
            [new Date('{{$vamola->fecha_test}}'),
            {{$vamola->num_problemas_conocidos_a}},
            {{$vamola->num_problemas_conocidos_aa}},
            {{$vamola->num_problemas_conocidos_aaa}}],
        @endforeach
        ]);

        var options = {
            title: 'Vamolà - Número de criterios con problemas conocidos según nivel de conformidad',
            vAxis: { 
                minValue:0,
                maxValue: 5,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff','#ff6600','#009900'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
                1: { pointShape: 'circle' },
                2: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('vamola-conocidos'));

        chart.draw(data, options);
    }

    function v_potenciales() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de criterios con problemas potenciales de nivel A');
        data.addColumn('number', 'Número de criterios con problemas potenciales de nivel AA');
        data.addColumn('number', 'Número de criterios con problemas potenciales de nivel AAA');


        data.addRows([
        @foreach ($vamolas as $vamola)
            [new Date('{{$vamola->fecha_test}}'),
            {{$vamola->num_problemas_potenciales_a}},
            {{$vamola->num_problemas_potenciales_aa}},
            {{$vamola->num_problemas_potenciales_aaa}}],
        @endforeach
        ]);

        var options = {
            title: 'Vamolà - Número de problemas potenciales según nivel de conformidad',
            vAxis: { 
                minValue:0,
                maxValue: 5,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff','#ff6600','#009900'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
                1: { pointShape: 'circle' },
                2: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('vamola-potenciales'));

        chart.draw(data, options);
    }


    /*WAVE*/
    @if (in_array(6,$herramientas) && (count($waves)>0))
        google.charts.setOnLoadCallback(w_problemas_advertencias);
        google.charts.setOnLoadCallback(w_caracteristicas_aria);
    @endif
    
    function w_problemas_advertencias() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de problemas de accesibilidad');
        data.addColumn('number', 'Número de advertencias de accesibilidad');
        data.addColumn('number', 'Número de problemas de contraste');


        data.addRows([
        @foreach ($waves as $wave)
            [new Date('{{$wave->fecha_test}}'),
            {{$wave->num_problemas}},
            {{$wave->num_advertencias}},
            {{$wave->num_problemas_contraste}}],
        @endforeach
        ]);

        var options = {
            title: 'WAVE - Número de problemas y advertencias de accesibilidad, y problemas de contraste',
            vAxis: { 
                minValue:0,
                maxValue: 5,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff','#ff6600','#009900'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
                1: { pointShape: 'circle' },
                2: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('wave-problemas'));

        chart.draw(data, options);
    }

    function w_caracteristicas_aria() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de características');
        data.addColumn('number', 'Número de elementos ARIA');


        data.addRows([
        @foreach ($waves as $wave)
            [new Date('{{$wave->fecha_test}}'),
            {{$wave->num_caracteristicas}},
            {{$wave->num_elem_ARIA}}],
        @endforeach
        ]);

        var options = {
            title: 'WAVE - Número de características y de elementos ARIA',
            vAxis: { 
                minValue:0,
                maxValue: 5,
                format:'0.00',
            },
            hAxis: {
                format: 'dd MMM yyyy'
            },
            colors: ['#0066ff','#ff6600'],
            pointSize: 5,
            series: {
                0: { pointShape: 'circle' },
                1: { pointShape: 'circle' },
            }
            
        };

        var chart = new google.visualization.LineChart(document.getElementById('wave-caracteristicas'));

        chart.draw(data, options);
    }
  </script>






@endsection


@section('content')

<h1 class="h1-encabezado"> Sitio Web </h1>

<hr>

<div class="container">
    <div class="col-md-10">
        <div style="margin-bottom: 1.5em">
            <p> <strong>Nombre del sitio: </strong>{{$sitio->nombre}} </p>
            <p><strong> Dirección web: </strong> <a href="http://{{ $sitio->dominio }}" target="_blank">{{ $sitio->dominio }}</a>

            <h2>Horario de evaluación</h2>
            <p><strong>Periodicidad: </strong>{{$sitio->periodicidad}}</p>

            @if ($sitio->periodicidad === "Semanal")
            <p><strong>Día de la semana: </strong>{{$dia}}</p>
            @elseif ($sitio->periodicidad === "Mensual")
            <p><strong>Día mensual: </strong>{{$sitio->dia}}</p>
            @endif

            <p><strong>Hora: </strong>{{$sitio->hora}}</p>
        </div>
    </div>
</div>

@if(isset($paginas))
<hr>
<div class="container">
    <div class="col-md-10">
        <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#paginas">Mostrar listado de páginas web del sitio</button>
        <div id="paginas" class="collapse" style="margin-top: 2em;">
            <table class="table" summary="Tabla para ver las páginas webs pertenencientes al actual sitio web">
                <thead>
                    <tr>
                        <th style="text-align: left">Página web</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paginas as $pagina)
                    <tr>
                        <td style="text-align: left">
                            <a href="/pagina/{{ $pagina->id }}" >{{$pagina->URL}}</a>
                        </td>
                    </tr>
                    @endforeach
                <tbody>
            </table>
        </div>
    </div>
</div>

@endif

<hr>

<div class="container">
    <div class="col-md-12">
        <div style="margin-bottom: 1.5em">
            <h2>Resultados de las herramientas</h2>

            @if (in_array(1,$herramientas) && (count($accessmonitors)>0))
            <h3> AccessMonitor</h3>
            <div class ="grafico" id="accessmonitor-puntuacion" ></div>
            <div class ="grafico" id="accessmonitor-problemas" ></div>
            <div class ="grafico" id="accessmonitor-advertencias"></div>

            <hr>

            @endif

            @if (in_array(2,$herramientas) && (count($acheckers)>0))
            <h3> Achecker </h3>
            <div class ="grafico" id="achecker-total-conocidos"></div>
            <div class ="grafico" id="achecker-total-potenciales"></div>
            <div class ="grafico" id="achecker-conocidos"></div>
            <div class ="grafico" id="achecker-potenciales"></div>

            <hr>
            @endif

            @if (in_array(3,$herramientas) && (count($eiiicheckers)>0))
            <h3> EIII Page Checker </h3>
            <div class ="grafico" id="eiiichecker-puntuacion"></div>
            <div class ="grafico" id="eiiichecker-total"></div>
            <div class ="grafico" id="eiiichecker-problemas"></div>

            <hr>
            @endif

            @if (in_array(4,$herramientas) && (count($observatorios)>0))
            <h3> Observatorio de la UPS de Ecuador </h3>
            <div class ="grafico" id="observatorio-porcentajes"></div>
            <div class ="grafico" id="observatorio-problemas"></div>
            <div class ="grafico" id="observatorio-advertencias"></div>

            <hr>
            @endif

            @if (in_array(5,$herramientas) && (count($vamolas)>0))
            <h3> Vamolà </h3>
            <div class ="grafico" id="vamola-total-conocidos"></div>
            <div class ="grafico" id="vamola-total-potenciales"></div>
            <div class ="grafico" id="vamola-conocidos"></div>
            <div class ="grafico" id="vamola-potenciales"></div>

            <hr>
            @endif

            @if (in_array(6,$herramientas) && (count($waves)>0))
            <h3> WAVE </h3>
            <div class ="grafico" id="wave-problemas"></div>
            <div class ="grafico" id="wave-caracteristicas"></div>

            <hr>
            @endif

        </div>
    </div>
</div>


@endsection