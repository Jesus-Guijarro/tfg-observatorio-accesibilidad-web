<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pagina;
use App\Sitio;

use App\Accessmonitor;
use App\Achecker;
use App\Eiiichecker;
use App\Observatorio;
use App\Vamola;
use App\Wave;


class PaginaController extends Controller
{
    public function mostrarPagina($id){
        $p = new Pagina();
        $pagina = $p->getPagina($id);

        return view('pages.pagina', array('pagina' => $pagina));
    }

    public function mostrarReporteAutomatico($reporte){

        return view('pages.reporte.automatico', array('reporte' => $reporte));
    }

    
}
