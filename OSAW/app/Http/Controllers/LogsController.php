<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class LogsController extends Controller
{
    //Función para mostrar los logs de errores durante la evaluación de los sitios
    public function mostrarLogs(){

        $logs_paginas=Storage::disk('public')->files('logs/paginas');
        $logs_paginas=array_reverse($logs_paginas);
        
        $logs_herramientas=Storage::disk('public')->files('logs/herramientas');
        $logs_herramientas=array_reverse($logs_herramientas);

        return view('pages.administrador.logs', array('logs_paginas' => $logs_paginas,'logs_herramientas' => $logs_herramientas));
    }


    public function mostrarLog($log){

        $log=str_replace("+","/",$log);

        if(strpos($log,"paginas")){
            $fecha=str_replace("logs/paginas/log_paginas_","",$log);
            $tipo="Pagina";
        }
        else{
            $fecha=str_replace("logs/herramientas/log_herramientas_","",$log);
            $tipo="Herramienta";
        }
        
        $fecha=str_replace(".log","",$fecha);

        return view('pages.administrador.log', array('log' => $log,'fecha'=>$fecha,'tipo'=>$tipo));
    }
}
