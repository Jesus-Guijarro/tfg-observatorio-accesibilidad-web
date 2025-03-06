@extends('layouts.master')

@section('titulo', 'Pagina de inicio')

@section('content')
<h1 class ="h1-encabezado-inicio"> Bienvenido al Observatorio para el Seguimiento de la Accesibilidad Web (OSAW)</h1>

<hr>

<h2>Objetivo principal</h2>
<p> El <strong>Observatorio para el Seguimiento de la Accesibilidad Web </strong> se ha desarrollado con la finalidad de poder realizar un seguimiento de aquellos sitios web que por ley deben ser accesibles. </p>
<p>Para llevar a cabo esta tarea se ha hecho uso de herramientas online gratuitas de evaluación de la accesibilidad web: </p>
<ul>
    <li><a href="http://www.acessibilidade.gov.pt/accessmonitor/" target="_blank">AccessMonitor</a></li>
    <li><a href="https://achecker.ca/checker/index.php"target="_blank">Achecher</a></li>
    <li><a href="http://checkers.eiii.eu/en/pagecheck/"target="_blank">EIII Page Checker </a></li>
    <li><a href="http://observatorioweb.ups.edu.ec/oaw/index.jsf"target="_blank">Observatorio de Accesibilidad Web de la Universidad Politécnica Salesiana de Ecuador</a>
    <li><a href="http://www.validatore.it/vamola_validator/checker/index.php"target="_blank">Vamolà</a></li>
    <li><a href="https://wave.webaim.org/"target="_blank">WAVE</a></li>
</ul>

<p>Los análisis se hacen de forma periodica y automática, pudiéndose selecionar la periodicidad de estos para que sea diaria, semanal o mensual. </p>
<p>También es posible indicar el día de la semana o mes, y la hora del análisis.</p>

<hr>

<h2>Datos del observatorio</h2>

<p>Número total de <strong>sitios web</strong> analizados: <strong>{{$num_sitios}}</strong> </p>
<p><a href="/lista-sitios">Ver sitios webs analizados </a></p>
<p>Número total de <strong>paginas web</strong> evaluadas: <strong>{{$num_paginas}}</strong></p>  


<h3> Número de evaluaciones realizadas por cada herramienta</h3>


<table class="table" style="width:50%" summary="Tabla que contiene las herramientas utilizadas por el observatorio en la primera columna y su respectivo número de análisis en la segunda columna">
    <caption>Herramientas de análisis utilizadas y el número de evaluaciones realizadas por cada una de ellas</caption>
    <thead>
        <tr>
            <th>Herramienta</th>
            <th>Número de evaluaciones</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td >AccessMonitor</td>
            <td> {{$num_accessmonitors}}</td>
        </tr>
        <tr>
            <td >AChecker</td>
            <td> {{$num_acheckers}}</td>
        </tr>
        <tr>
            <td >EIII Page Checker</td>
            <td> {{$num_eiiicheckers}}</td>
        </tr>
        <tr>
            <td >Observatorio Accesibilidad Web UPS de Ecuador</td>
            <td> {{$num_observatorios}}</td>
        </tr>
        <tr>
            <td >Vamolà</td>
            <td> {{$num_vamolas}}</td>
        </tr>
        <tr>
            <td >WAVE</td>
            <td> {{$num_waves}}</td>
        </tr>
    <tbody>
</table>

@endsection
