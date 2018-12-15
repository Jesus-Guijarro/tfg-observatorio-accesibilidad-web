google.charts.load('current', {'packages':['line']});
    google.charts.setOnLoadCallback(puntuacion);
    google.charts.setOnLoadCallback(problemas);
    google.charts.setOnLoadCallback(advertencias);

    function puntuacion() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de la evaluación');
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

        var chart = new google.charts.Line(document.getElementById('accessmonitor_puntuacion'));

        chart.draw(data, options);
    }

    function problemas() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de la evaluación');
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

        var chart = new google.charts.Line(document.getElementById('accessmonitor_problemas'));

        chart.draw(data, options);
    }
    
    function advertencias() {

        var data = new google.visualization.DataTable();

        data.addColumn('date', 'Fecha de la evaluación');
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

        var chart = new google.charts.Line(document.getElementById('accessmonitor_advertencias'));

        chart.draw(data, options);
    }