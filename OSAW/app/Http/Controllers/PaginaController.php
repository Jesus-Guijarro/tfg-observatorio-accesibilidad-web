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
    //Función para mostrar los datos de una página perteneciente a un sitio web
    public function mostrarPagina($id){
        
        //Datos de la página
        $p = new Pagina();
        $pagina = $p->getPagina($id);

        //Datos del sitio al que pertenece
        $sitio = $p->getSitioPagina($id);

        //Herramientas utilizada por el sitio
        $h = new Herramienta();
        $herramientas= $h->getHerramientasSitio($sitio->id);

        //Datos y reportes de las evaluaciones de cada herramienta 

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

    //Función para mostrar un reporte de evaluación
    public function mostrarReporteAutomatico($reporte){

        //Se reemplaza el carácter '/' por problemas con las rutas de Laravel
        $reporte=str_replace("+","/",$reporte);

        return view('pages.reporte.automatico', array('reporte' => $reporte));
    }

    //Función para mostrar la gestión de las páginas de un sitio web.
    public function gestionarPaginas($sitio_id){

        $sitio = new Sitio();
        $paginas = $sitio->getPaginasSitio($sitio_id);

        return view('pages.administrador.gestionar-paginas', array('sitio_id'=>$sitio_id,'paginas' => $paginas));
    }

    //Función para añadir una nueva página al sitio
    public function crearPagina(Request $request, $sitio_id){

        $url=$request->url;

        //Se eliminan caracteres de escape y espacios
        $url=str_replace(array("\n","\r\n","\r"," "),"",$url);

        //Se comprueba que el dominio del sitio se encuentra en la URL
        $sitio=Sitio::findOrFail($sitio_id);
        if(!strpos($url, $sitio->dominio)){
            return back()->withErrors(['url'=>'No se encuentra el dominio del sitio en la URL']);
        }

        //Expresión regular para comprobar una url del formato "http|https://X.Y"
        $regex = '/((http|https)\:\/\/)[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
        if(!preg_match($regex,$url)){
            return back()->withErrors(['url'=>'La URL no tiene el formato adecuado']);
        }

        //Se verifica que se puede acceder a la URL
        //HTTP 1.0 o 1.1
        if(strpos(get_headers($url)[0],"200 OK")===false){
            return back()->withErrors(['url'=>'No se puede acceder a la URL']);
        }

        
        //Última comprobación por si la página es nueva o no
        $p = new Pagina();
        $nueva = $p->paginaNueva($url);
        if($nueva){
            //Se añade en caso positivo
            $p->crearPagina($sitio_id,$url);
        }
        else{
            return back()->withErrors(['url'=>'La URL ya se encuentra añadida']);
        }
        
        return back()->with('mensaje', 'La página se ha añadido con éxito');
    }

    //Función para mostrar el panel para actualizar una página
    public function panelModificarPagina($id){

        $p = new Pagina();
        $pagina = $p->getPagina($id);
        
        return view('pages.administrador.modificar-pagina',array('id'=>$id,'pagina'=>$pagina));
    }

    //Función para modificar la página
    public function modificarPagina(Request $request, $id){

        $url =  $request->url;

        $p = new Pagina();
        $pagina = $p->getPagina($id);

        //Se eliminan caracteres de escape y espacios
        $url=str_replace(array("\n","\r\n","\r"," "),"",$url);

        //Se comprueba que el dominio del sitio se encuentra en la URL
        $sitio=Sitio::findOrFail($pagina->sitio_id);
        if(!strpos($url, $sitio->dominio)){
            return back()->withErrors(['url'=>'No se encuentra el dominio del sitio en la URL']);
        }

        //Expresión regular para comprobar una url del formato "http|https://X.Y"
        $regex = '/((http|https)\:\/\/)[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
        if(!preg_match($regex,$url)){
            return back()->withErrors(['url'=>'La URL no tiene el formato adecuado']);
        }

        //Se verifica que se puede acceder a la URL
        if(strpos(get_headers($url)[0],"200 OK")===false){
            return back()->withErrors(['url'=>'No se puede acceder a la URL']);
        }
        if($p->paginaNueva($url)){
            //Se añade en caso positivo
            $pagina->actualizarPagina($id,$url);
        }
        else{
            return back()->withErrors(['url'=>'La URL ya se encuentra añadida']);
        }
        return back()->with('mensaje', 'La página se ha modificado con éxito');
    }

    //Función para eliminar una página
    public function eliminarPagina($id){

        $p = new Pagina();
        $pagina = $p->borrarPagina($id);

        return back();
        
    }
    
}
