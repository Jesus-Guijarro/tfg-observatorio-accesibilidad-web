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
use Symfony\Component\HttpFoundation\File\File;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;


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

        $reporte=str_replace("+","/",$reporte);

        $nombre_reporte=$reporte;


        return view('pages.reporte.automatico', array('reporte' => $reporte,'nombre_reporte'=>$nombre_reporte));
    }

    public function gestionarPaginas($sitio_id){

        $sitio = new Sitio();
        $paginas = $sitio->getPaginasSitio($sitio_id);

        return view('pages.administrador.gestionar-paginas', array('sitio_id'=>$sitio_id,'paginas' => $paginas));
    }

    public function crearPagina(Request $request, $sitio_id){

        $url=$request->url;
        $url=str_replace(array("\r\n","\r"," "),"",$url);

        $regex = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';

        
        if(preg_match($regex,$url)){
            $p = new Pagina();
            $nueva = $p->paginaNueva($url);
                if($nueva){
                    $p->crearPagina($url, $sitio_id);
                }
        }
        
        return back()->with('mensaje', 'La página se ha añadido con éxito');
    }

    public function panelModificarPagina($id){

        $p = new Pagina();

        $pagina = $p->getPagina($id);
        
        return view('pages.administrador.modificar-pagina',array('id'=>$id,'pagina'=>$pagina));

        //return back()->with('mensaje', 'La página se ha modificado con éxito');
        
    }

    public function modificarPagina(Request $request, $id){

        $url =  $request->url;

        $p = new Pagina();

        $pagina = $p->getPagina($id);
        $pagina->actualizarPagina($id,$url);

        return back()->with('mensaje', 'La página se ha modificado con éxito');
        
    }

    public function eliminarPagina($id){

        $p = new Pagina();

        $pagina = $p->borrarPagina($id);

        return back();
        
    }
    
}
