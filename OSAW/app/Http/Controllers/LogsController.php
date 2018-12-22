<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogsController extends Controller
{
    //Función para mostrar los logs de errores durante la evaluación de los sitios
    public function mostrarLogs(){

        $logs_paginas=Storage::disk('public')->files('logs/paginas');
        $logs_herramientas=Storage::disk('public')->files('logs/herramientas');

        return view('pages.administrador.logs', array('logs_paginas' => $logs_paginas,'logs_herramientas' => $logs_herramientas));
    }
}
