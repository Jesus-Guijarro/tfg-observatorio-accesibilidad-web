<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sitio;
use App\Pagina;
use App\Categoria;
use App\Herramienta;

use App\Accessmonitor;
use App\Achecker;
use App\Eiiichecker;
use App\Observatorio;
use App\Vamola;
use App\Wave;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class SitioController extends Controller
{

    public function mostrarSitio($id){
        $s = new Sitio();

        $sitio = $s->getSitio($id);
        $dia = $s->getDiaAnalisis($id);
        $paginas = $s->getPaginasSitio($id);

        $h = new Herramienta();
        $herramientas= $h->getHerramientasSitio($id);

        $am = new Accessmonitor();
        $accessmonitors = $am->getAccessmonitorsSitioGraficos($id);

        $ac = new Achecker();
        $acheckers = $ac->getAcheckersSitioGraficos($id);

        $ei = new Eiiichecker();
        $eiiicheckers = $ei->getEiiicheckersSitioGraficos($id);

        $o = new Observatorio();
        $observatorios = $o->getObservatoriosSitioGraficos($id);

        $v = new Vamola();
        $vamolas = $v->getVamolasSitioGraficos($id);

        $w = new Wave();
        $waves = $w->getWavesSitioGraficos($id);

        return view('pages.sitio', array('sitio' => $sitio, 'dia'=>$dia,'paginas' => $paginas,
        'herramientas' => $herramientas, 
        'accessmonitors' => $accessmonitors,'acheckers' => $acheckers,
        'eiiicheckers' => $eiiicheckers,'observatorios' => $observatorios,
        'vamolas' => $vamolas,'waves' => $waves
     ));
    }

    public function listarSitios(){
        $sitio = new Sitio();
        $sitios = $sitio->getSitios();

        $c = new Categoria();
        $categorias = $c->getCategorias();

        return view('pages.lista-sitios', array('sitios' => $sitios,'categorias'=>$categorias));

    }

    public function busquedaSitio(){

        $nombre =  Input::get('nombre');

        $sitio = new Sitio();
        $sitios = $sitio->getSitiosBusqueda($nombre);

        $c = new Categoria();
        $categorias = $c->getCategorias();

        return view('pages.busqueda-sitios', array('sitios' => $sitios,'nombre' => $nombre,'categorias'=>$categorias));
    }


    //Administración de sitios

    public function gestionarSitios(){

        $nombre =  Input::get('nombre');

        $sitio = new Sitio();
        $sitios = $sitio->getSitiosBusqueda($nombre);

        return view('pages.administrador.gestionar-sitios', array('sitios' => $sitios));
    }

    //CREAR SITIO
    public function panelCrearSitio(){

        $categoria = new Categoria();
        $categorias = $categoria->getCategorias();

        $herramienta = new Herramienta();
        $herramientas = $herramienta->getHerramientasActivas();


        return view('pages.administrador.crear-sitio', array('categorias' => $categorias,'herramientas' => $herramientas));
    }


    public function crearSitio(Request $request){

        //Validaciones
        $this->validate($request, [
            'nombre' => 'required|string|unique:sitios|min:2|max:70',
            'dominio' => ['required','regex:/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/'],
            'num_paginas' => 'min:0|max:20|integer',
            'hora' => ['required','regex:/^([0-1][0-9]|[2][0-3]):([0-5][0-9])?$/'],
            'dia' => 'required|integer|min:0',
        ]);

    
        //Validar dia semana o mes

        $periodicidad=$request->periodicidad;
        $dia=$request->dia;

        if ($periodicidad=="Semanal"){
            if ($dia<0 or $dia>6){
                return Redirect::back()->withErrors(['dia'=>'El día debe de ser entre 0 y 6.']);
            }
        }
        elseif($periodicidad=="Mensual"){
            if ($dia<1 or $dia>31){
                return Redirect::back()->withErrors(['dia'=>'El día debe de ser entre 1 y 31.']);
            }
        }

        //Proceso de creación

        $nombre=$request->nombre;
        $dominio=$request->dominio;
        $categoria_id=$request->categoria;
        $hora=$request->hora;

        
        //Automatizado
        $automatizado = true;
        
        if($request->automatizado!="on"){
            $automatizado = false;
        }

        

        $s = new Sitio();
        $id= $s->crearSitio($nombre,$dominio,$periodicidad,$hora,$dia,$automatizado,$categoria_id);

        //Herramientas
        $sitio=$s->getSitio($id);
        $herramientas = [$request->accessmonitor,$request->achecker,$request->eiiichecker,$request->observatorio, $request->vamola,$request->wave];
        foreach($herramientas as $herramienta){
            if($herramienta!=0){
                $sitio->herramientas()->attach($herramienta);
            }
        }
       
        //Páginas web
        if($request->paginas){
            //Operaciones para obtener cada linea, quitar saltos de línea y espacios de las cadenas
            $lista_paginas = explode("\n", $request->paginas);
            $paginas = array();
            foreach($lista_paginas as $pagina){
                $pagina=str_replace(array("\r\n","\r"," "),"",$pagina);
                array_push($paginas, $pagina);
            }

            $regex = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';

            $p = new Pagina();
            foreach($paginas as $pagina){
                if(preg_match($regex,$pagina)){
                    $nueva = $p->paginaNueva($pagina);
                    if($nueva){
                        $p->crearPagina($pagina,$id);
                    }
                }
            }
        }
        
        
        //Ruta archivos Web Scraping
        list($scriptPath) = get_included_files();
        $ruta = $scriptPath;
        $ruta_webscraping=str_replace("/OSAW/server.php","/Webscraping/",$ruta);

        //Llamada crawler
        
        $num_paginas=$request->num_paginas;
        $comando="/usr/bin/python3 ".$ruta_webscraping."crawler.py ".$id." ".$num_paginas;

        $crawler = new Process($comando);
        $crawler->run();

        //Llamada a cron
        if($automatizado){
            $comando='/usr/bin/python3 '.$ruta_webscraping.'cron.py '.$id.' C';
            $cron = new Process($comando);
            $cron->run();
        }
        else{
            $comando='/usr/bin/python3 '.$ruta_webscraping.'cron.py '.$id.' E';
            $cron = new Process($comando);
            $cron->run();
        }
        
        return redirect("/crear-sitio")->with('mensaje', 'El sitio se ha creado con éxito');
    }

    //MODIFICAR SITIO
    public function panelModificarSitio($id){

        $s = new Sitio();
        $sitio = $s->getSitio($id);

        $herramientas_sitio = $sitio->getHerramientasSitio($id);
        
        $categoria = new Categoria();
        $categorias = $categoria->getCategorias();

        $herramienta = new Herramienta();
        $herramientas = $herramienta->getHerramientasActivas();

        

        return view('pages.administrador.modificar-sitio', array('sitio' => $sitio,'categorias' => $categorias,'herramientas' => $herramientas,'herramientas_sitio'=>$herramientas_sitio));
    }

    public function modificarSitio(Request $request, $id){

        $sitio = Sitio::findOrFail($id);

        //Validaciones
        $this->validate($request, [
            'nombre' => 'required|string|min:2|max:70|unique:sitios,nombre,'.$sitio->id,
            'dominio' => ['required','regex:/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/'],
            'num_paginas' => 'min:0|max:20|integer',
            'hora' => ['required','regex:/^([0-1][0-9]|[2][0-3]):([0-5][0-9])?$/'],
            'dia' => 'required|integer|min:0',
        ]);

    
        //Validar dia semana o mes

        $periodicidad=$request->periodicidad;
        $dia=$request->dia;

        if ($periodicidad=="Semanal"){
            if ($dia<0 or $dia>6){
                return Redirect::back()->withErrors(['dia'=>'El día debe de ser entre 0 y 6.']);
            }
        }
        elseif($periodicidad=="Mensual"){
            if ($dia<1 or $dia>31){
                return Redirect::back()->withErrors(['dia'=>'El día debe de ser entre 1 y 31.']);
            }
        }

        //Proceso de creación

        $nombre=$request->nombre;
        $dominio=$request->dominio;
        $categoria_id=$request->categoria;
        $hora=$request->hora;

        //Automatizado
        $automatizado = true;
        
        if($request->automatizado!="on"){
            $automatizado = false;
        }

        $s = new Sitio();
        $s->actualizarSitio($id,$nombre,$dominio,$periodicidad,$hora,$dia,$automatizado,$categoria_id);

        //Herramientas
        $sitio = $s->getSitio($id);

        $herramientas_sitio = $sitio->getHerramientasSitio($id);

        $herramientas = [$request->accessmonitor,$request->achecker,$request->eiiichecker,$request->observatorio, $request->vamola,$request->wave];
        foreach($herramientas as $herramienta){

            if(is_numeric($herramienta)){
                if(!in_array($herramienta, $herramientas_sitio)){
                    $sitio->herramientas()->attach($herramienta);
                }
            }
            else{
                $partes = explode(":", $herramienta);
                $herramienta_id=$partes[1];
                if(in_array($herramienta_id, $herramientas_sitio)){
                    $sitio->herramientas()->detach($herramienta_id);
                }
                
            }



        }
       
        //Páginas web
        if($request->paginas){
            //Operaciones para obtener cada linea, quitar saltos de línea y espacios de las cadenas
            $lista_paginas = explode("\n", $request->paginas);
            $paginas = array();
            foreach($lista_paginas as $pagina){
                $pagina=str_replace(array("\r\n","\r"," "),"",$pagina);
                array_push($paginas, $pagina);
            }

            $regex = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';

            $p = new Pagina();
            foreach($paginas as $pagina){
                if(preg_match($regex,$pagina)){
                    $nueva = $p->paginaNueva($pagina);
                    if($nueva){
                        $p->crearPagina($pagina,$id);
                    }
                }
            }
        }
        
        //Ruta archivos Web Scraping
        list($scriptPath) = get_included_files();
        $ruta = $scriptPath;
        $ruta_webscraping=str_replace("/OSAW/server.php","/Webscraping/",$ruta);

        //Llamada crawler
        $num_paginas=$request->num_paginas;
        $comando_crawler='/usr/bin/python3 '.$ruta_webscraping.'crawler.py '.$id.' '.$num_paginas;
        $crawler = new Process($comando_crawler);
        $crawler->run();
        
        //Llamada a cron
        if($automatizado){
            $comando='/usr/bin/python3 '.$ruta_webscraping.'cron.py '.$id.' A';
            $cron = new Process($comando);
            $cron->run();
        }
        else{
            $comando='/usr/bin/python3 '.$ruta_webscraping.'cron.py '.$id.' E';
            $cron = new Process($comando);
            $cron->run();
        }
    
        return redirect('/modificar-sitio/'.$id)->with('mensaje', 'El sitio se ha modificado con éxito');

    }

    //ELIMINAR
    public function eliminarSitio($id){

        $s = new Sitio();
        $sitio = $s->borrarSitio($id);

        return redirect('gestionar-sitios');
    }

}
