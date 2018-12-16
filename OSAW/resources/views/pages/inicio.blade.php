@extends('layouts.master')

@section('titulo', 'Pagina de inicio')

@section('content')
<h1> ¡Bienvenido al Observatorio para el Seguimiento de la Accesibilidad Web (OSAW)!</h1>
<p> En la actualidad el observatorio hace uso de las siguientes herramientas online gratuitas para realizar los análisis y seguimiento de los sitios institucionales:</p>

<ul>
    <a href="http://www.acessibilidade.gov.pt/accessmonitor/" target="_blank"><li>AccessMonitor</li></a>
    <a href="https://achecker.ca/checker/index.php"target="_blank"><li>Achecher</li></a>
    <a href="http://checkers.eiii.eu/en/pagecheck/"target="_blank"><li>EIII Page Checker </li></a>
    <a href="http://observatorioweb.ups.edu.ec/oaw/index.jsf"target="_blank"><li>Observatorio de Accesibilidad Web de la Universidad Politécnica Salesiana de Ecuador </li></a>
    <a href="http://www.validatore.it/vamola_validator/checker/index.php"target="_blank"><li>Vamolà</li></a>
    <a href="https://wave.webaim.org/"target="_blank"><li>WAVE</li></a>
</ul>

<hr>

<h2>Datos del observatorio</h2>

<p>Número total de <strong>sitios web</strong> analizados: <strong>{{$num_sitios}}</strong> </p>
<p><a href="/lista-sitios">Ver sitios webs analizados </a></p>
<p>Número total de <strong>paginas web</strong> evaluadas: <strong>{{$num_paginas}}</strong></p>  

<hr>

<h3> Categorias Institucionales y de organización contempladas </h3>
<ul>
@foreach ($categorias as $categoria)
<li>{{$categoria->descripcion}}
@endforeach
</ul>

<hr>

<h3> Número de evaluaciones realizadas por cada herramienta </h3>

<table>
    <tr>
        <th>Herramienta</th>
        <th>Número de evaluaciones</th>
    </tr>
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
</table>

@endsection
