@extends('layouts.master')

@section('titulo', 'Página Web')

@section('scripts')
<script type="text/javascript">
    google.charts.load('current', {'packages':['line']});

    /*AccessMonitor*/
    @if (in_array(1,$herramientas))
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
            title: 'AccessMonitor'
        };

        var chart = new google.charts.Line(document.getElementById('accessmonitor-puntuacion'));

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
            title: 'B'
        };

        var chart = new google.charts.Line(document.getElementById('accessmonitor-problemas'));

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
            title: 'C'
        };

        var chart = new google.charts.Line(document.getElementById('accessmonitor-advertencias'));

        chart.draw(data, options);
    }

    /*Achecker*/
    @if (in_array(2,$herramientas))
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
            title: 'C'
        };

        var chart = new google.charts.Line(document.getElementById('achecker-total-conocidos'));

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
            title: 'C'
        };

        var chart = new google.charts.Line(document.getElementById('achecker-total-potenciales'));

        chart.draw(data, options);
    }

    function ac_conocidos() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de problemas conocidos de nivel de conformidad A');
        data.addColumn('number', 'Número de problemas conocidos de nivel de conformidad AA');
        data.addColumn('number', 'Número de problemas conocidos de nivel de conformidad AAA');


        data.addRows([
        @foreach ($acheckers as $achecker)
            [new Date('{{$achecker->fecha_test}}'),
            {{$achecker->num_problemas_conocidos_a}},
            {{$achecker->num_problemas_conocidos_aa}},
            {{$achecker->num_problemas_conocidos_aaa}}],
        @endforeach
        ]);

        var options = {
            title: 'C'
        };

        var chart = new google.charts.Line(document.getElementById('achecker-conocidos'));

        chart.draw(data, options);
    }

    function ac_potenciales() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de problemas potenciales de nivel de conformidad A');
        data.addColumn('number', 'Número de problemas potenciales de nivel de conformidad AA');
        data.addColumn('number', 'Número de problemas potenciales de nivel de conformidad AAA');


        data.addRows([
        @foreach ($acheckers as $achecker)
            [new Date('{{$achecker->fecha_test}}'),
            {{$achecker->num_problemas_potenciales_a}},
            {{$achecker->num_problemas_potenciales_aa}},
            {{$achecker->num_problemas_potenciales_aaa}}],
        @endforeach
        ]);

        var options = {
            title: 'C'
        };

        var chart = new google.charts.Line(document.getElementById('achecker-potenciales'));

        chart.draw(data, options);
    }

    /*EIIIChecker*/
    @if (in_array(3,$herramientas))
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
            title: 'C'
        };

        var chart = new google.charts.Line(document.getElementById('eiiichecker-puntuacion'));

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
            title: 'C'
        };

        var chart = new google.charts.Line(document.getElementById('eiiichecker-total'));

        chart.draw(data, options);
    }

    function ei_problemas() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de problemas de nivel de adecuación A');
        data.addColumn('number', 'Número de problemas de nivel de adecuación AA');

        data.addRows([
        @foreach ($eiiicheckers as $eiiichecker)
            [new Date('{{$eiiichecker->fecha_test}}'),
            {{$eiiichecker->num_problemas_a}},
            {{$eiiichecker->num_problemas_aa}}],
        @endforeach
        ]);

        var options = {
            title: 'C'
        };

        var chart = new google.charts.Line(document.getElementById('eiiichecker-problemas'));

        chart.draw(data, options);
    }


    /*Observatorio*/
    @if (in_array(4,$herramientas))
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
            title: 'C'
        };

        var chart = new google.charts.Line(document.getElementById('observatorio-porcentajes'));

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
            title: 'C'
        };

        var chart = new google.charts.Line(document.getElementById('observatorio-problemas'));

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
            title: 'C'
        };

        var chart = new google.charts.Line(document.getElementById('observatorio-advertencias'));

        chart.draw(data, options);
    }

    /*Vamola*/
    @if (in_array(5,$herramientas))
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
            title: 'C'
        };

        var chart = new google.charts.Line(document.getElementById('vamola-total-conocidos'));

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
            title: 'C'
        };

        var chart = new google.charts.Line(document.getElementById('vamola-total-potenciales'));

        chart.draw(data, options);
    }

    function v_conocidos() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de problemas conocidos de nivel de conformidad A');
        data.addColumn('number', 'Número de problemas conocidos de nivel de conformidad AA');
        data.addColumn('number', 'Número de problemas conocidos de nivel de conformidad AAA');


        data.addRows([
        @foreach ($vamolas as $vamola)
            [new Date('{{$vamola->fecha_test}}'),
            {{$vamola->num_problemas_conocidos_a}},
            {{$vamola->num_problemas_conocidos_aa}},
            {{$vamola->num_problemas_conocidos_aaa}}],
        @endforeach
        ]);

        var options = {
            title: 'C'
        };

        var chart = new google.charts.Line(document.getElementById('vamola-conocidos'));

        chart.draw(data, options);
    }

    function v_potenciales() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de problemas potenciales de nivel de conformidad A');
        data.addColumn('number', 'Número de problemas potenciales de nivel de conformidad AA');
        data.addColumn('number', 'Número de problemas potenciales de nivel de conformidad AAA');


        data.addRows([
        @foreach ($vamolas as $vamola)
            [new Date('{{$vamola->fecha_test}}'),
            {{$vamola->num_problemas_potenciales_a}},
            {{$vamola->num_problemas_potenciales_aa}},
            {{$vamola->num_problemas_potenciales_aaa}}],
        @endforeach
        ]);

        var options = {
            title: 'C'
        };

        var chart = new google.charts.Line(document.getElementById('vamola-potenciales'));

        chart.draw(data, options);
    }


    /*WAVE*/
    @if (in_array(6,$herramientas))
        google.charts.setOnLoadCallback(w_problemas_advertencias);
        google.charts.setOnLoadCallback(w_caracteristicas_aria);
    @endif
    
    function w_problemas_advertencias() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de evaluación');
        data.addColumn('number', 'Número de problemas');
        data.addColumn('number', 'Número de advertencias');
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
            title: 'C'
        };

        var chart = new google.charts.Line(document.getElementById('wave-problemas'));

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
            title: 'C'
        };

        var chart = new google.charts.Line(document.getElementById('wave-caracteristicas'));

        chart.draw(data, options);
    }
  </script>




@endsection


@section('content')

<h1> Página Web </h1>
<p style="text-decoration: underline"> <strong><a href='{{$pagina->URL}}' target="_blank">{{$pagina->URL}}</a></strong></p>
<p>Sitio web: <a href='{{url("sitio/$sitio->id")}}'>{{$sitio->nombre}}</a></p>
<a href="{{$pagina->archivo_HTML}}" download="reporte-pagina-{{$pagina->id}}">Descargar copia HTML</a>


<h2>Resultados de ejecución de las herramientas</h2>

@if (in_array(1,$herramientas))
<h3> AccessMonitor</h3>
<div id="accessmonitor-puntuacion" style="width: 700px; height: 400px;"></div>
<div id="accessmonitor-problemas" style="width: 700px; height: 400px;"></div>
<div id="accessmonitor-advertencias" style="width: 700px; height: 400px;"></div>

<table>
    <tr>
        <th>Reportes AccessMonitor</th>
    </tr>
    @foreach ($accessmonitors_reportes as $accessmonitors_reporte)
        <tr>
            @php
                {{$reporte=str_replace("/","+",$accessmonitors_reporte->datos_problemas);}}
                {{$reporte=str_replace("+storage+","",$reporte);}}
            @endphp
            <td>
                <a href="/reporte-automatico/{{$reporte}}">{{$accessmonitors_reporte->fecha_test}}</a></td>
        </tr>
    @endforeach
</table>
<div >
    {{ $accessmonitors_reportes->links() }}
</div>

@endif

@if (in_array(2,$herramientas))
<h3> Achecker </h3>
<div id="achecker-total-conocidos" style="width: 900px; height: 500px;"></div>
<div id="achecker-total-potenciales" style="width: 900px; height: 500px;"></div>
<div id="achecker-conocidos" style="width: 900px; height: 500px;"></div>
<div id="achecker-potenciales" style="width: 900px; height: 500px;"></div>

<table>
    <tr>
        <th>Reportes Achecker</th>
    </tr>
    @foreach ($acheckers_reportes as $acheckers_reporte)
        <tr>
            @php
                {{$reporte=str_replace("/","+",$acheckers_reporte->datos_problemas);}}
                {{$reporte=str_replace("+storage+","",$reporte);}}
            @endphp
            <td>
                <a href="/reporte-automatico/{{$reporte}}">{{$acheckers_reporte->fecha_test}}</a></td>
        </tr>
    @endforeach
</table>
<div >
    {{ $acheckers_reportes->links() }}
</div>
@endif

@if (in_array(3,$herramientas))
<h3> EIII Page Checker </h3>
<div id="eiiichecker-puntuacion" style="width: 900px; height: 500px;"></div>
<div id="eiiichecker-total" style="width: 900px; height: 500px;"></div>
<div id="eiiichecker-problemas" style="width: 900px; height: 500px;"></div>

<table>
    <tr>
        <th>Reportes EIII Page Checker</th>
    </tr>
    @foreach ($eiiicheckers_reportes as $eiiicheckers_reporte)
        <tr>
            @php
                {{$reporte=str_replace("/","+",$eiiicheckers_reporte->datos_problemas);}}
                {{$reporte=str_replace("+storage+","",$reporte);}}
            @endphp
        <td>
            <a href="/reporte-automatico/{{$reporte}}">{{$eiiicheckers_reporte->fecha_test}}</a></td>
        </tr>
    @endforeach
</table>
<div >
    {{ $eiiicheckers_reportes->links() }}
</div>

@endif

@if (in_array(4,$herramientas))
<h3> Observatorio de la UPS de Ecuador </h3>
<div id="observatorio-porcentajes" style="width: 900px; height: 500px;"></div>
<div id="observatorio-problemas" style="width: 900px; height: 500px;"></div>
<div id="observatorio-advertencias" style="width: 900px; height: 500px;"></div>

<table>
    <tr>
        <th>Reportes Observatorio de la UPS de Ecuador</th>
    </tr>
    @foreach ($observatorios_reportes as $observatorios_reporte)
        <tr>
            @php
                {{$reporte=str_replace("/","+",$observatorios_reporte->datos_problemas);}}
                {{$reporte=str_replace("+storage+","",$reporte);}}
            @endphp
        <td>
            <a href="/reporte-automatico/{{$reporte}}">{{$observatorios_reporte->fecha_test}}</a></td>
        </tr>
    @endforeach
</table>
<div >
    {{ $observatorios_reportes->links() }}
</div>
@endif

@if (in_array(5,$herramientas))
<h3> Vamolà </h3>
<div id="vamola-total-conocidos" style="width: 900px; height: 500px;"></div>
<div id="vamola-total-potenciales" style="width: 900px; height: 500px;"></div>
<div id="vamola-conocidos" style="width: 900px; height: 500px;"></div>
<div id="vamola-potenciales" style="width: 900px; height: 500px;"></div>

<table>
    <tr>
        <th>Reportes Vamolà</th>
    </tr>
    @foreach ($vamolas_reportes as $vamolas_reporte)
        <tr>
            @php
                {{$reporte=str_replace("/","+",$vamolas_reporte->datos_problemas);}}
                {{$reporte=str_replace("+storage+","",$reporte);}}
            @endphp
        <td>
            <a href="/reporte-automatico/{{$reporte}}">{{$vamolas_reporte->fecha_test}}</a></td>
        </tr>
    @endforeach
</table>
<div >
    {{ $vamolas_reportes->links() }}
</div>
@endif

@if (in_array(6,$herramientas))
<h3> WAVE </h3>
<div id="wave-problemas" style="width: 900px; height: 500px;"></div>
<div id="wave-caracteristicas" style="width: 900px; height: 500px;"></div>

<table>
    <tr>
        <th>Reportes WAVE</th>
    </tr>
    @foreach ($waves_reportes as $waves_reporte)
        <tr>
            @php
                {{$reporte=str_replace("/","+",$waves_reporte->datos_problemas);}}
                {{$reporte=str_replace("+storage+","",$reporte);}}
            @endphp
        <td>
            <a href="/reporte-automatico/{{$reporte}}">{{$waves_reporte->fecha_test}}</a></td>
        </tr>
    @endforeach
</table>
<div >
    {{ $waves_reportes->links() }}
</div>

@endif

@endsection