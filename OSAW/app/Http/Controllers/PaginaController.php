<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pagina;
use App\Sitio;
use App\Herramienta;

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

        $sitio = $p->getSitioPagina($id);

        $h = new Herramienta();
        $herramientas= $h->getHerramientasSitio($sitio->id);

        $am = new Accessmonitor();
        $accessmonitors = $am->getAccessmonitorsPaginaGraficos($id);
        $accessmonitors_reportes = $am->getAccessmonitorsPaginaReportes($id);

        $ac = new Achecker();
        $acheckers = $ac->getAcheckersPaginaGraficos($id);
        $acheckers_reportes = $ac->getAcheckersPaginaReportes($id);

        $ei = new Eiiichecker();
        $eiiicheckers = $ei->getEiiicheckersPaginaGraficos($id);
        $eiiicheckers_reportes = $ei->getEiiicheckersPaginaReportes($id);

        $o = new Observatorio();
        $observatorios = $o->getObservatoriosPaginaGraficos($id);
        $observatorios_reportes = $o->getObservatoriosPaginaReportes($id);

        $v = new Vamola();
        $vamolas = $v->getVamolasPaginaGraficos($id);
        $vamolas_reportes = $v->getVamolasPaginaReportes($id);

        $w = new Wave();
        $waves = $w->getWavesPaginaGraficos($id);
        $waves_reportes = $w->getWavesPaginaReportes($id);

        return view('pages.pagina', array('pagina' => $pagina,'sitio' => $sitio, 
            'herramientas' => $herramientas, 
            'accessmonitors' => $accessmonitors,'accessmonitors_reportes' => $accessmonitors_reportes,
            'acheckers' => $acheckers,'acheckers_reportes' => $acheckers_reportes,
            'eiiicheckers' => $eiiicheckers,'eiiicheckers_reportes' => $eiiicheckers_reportes,
            'observatorios' => $observatorios,'observatorios_reportes' => $observatorios_reportes,
            'vamolas' => $vamolas, 'vamolas_reportes' => $vamolas_reportes,
            'waves' => $waves, 'waves_reportes' => $waves_reportes
        ));
    }

    public function mostrarReporteAutomatico($reporte){

        return view('pages.reporte.automatico', array('reporte' => $reporte));
    }

    
}
