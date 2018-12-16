<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sitio;
use App\Categoria;
use App\Herramienta;

use App\Accessmonitor;
use App\Achecker;
use App\Eiiichecker;
use App\Observatorio;
use App\Vamola;
use App\Wave;

use Illuminate\Support\Facades\Input;

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


    #   Administración de sitios

    public function gestionarSitios(){

        $nombre =  Input::get('nombre');

        $sitio = new Sitio();
        $sitios = $sitio->getSitiosBusqueda($nombre);

        return view('pages.administrador.gestionar-sitios', array('sitios' => $sitios));
    }

    public function panelCrearSitio(){

        $categoria = new Categoria();
        $categorias = $categoria->getCategorias();

        $herramienta = new Herramienta();
        $herramientas = $herramienta->getHerramientasActivas();


        return view('pages.administrador.crear-sitio', array('categorias' => $categorias,'herramientas' => $herramientas));
    }


    public function crearSitio(Request $request){

        $this->validate($request, [
            'nombre' => 'required|unique:sitios|min:4|max:70',
            'dominio' => ['required','regex:/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/'],
            'num_paginas' => 'min:0|max:20|integer',
            'hora' => ['required','regex:/^([0-1][0-9]|[2][0-3]):([0-5][0-9])?$/'],
            'dia' => 'required|min:0',
        ]);

        $nombre=$request->nombre;
        $dominio=$request->dominio;
        $categoria_id=$request->categoria;



        //Herramientas
        $accessmonitor=$request->accessmonitor;
        $achecker=$request->achecker;
        $eiiichecker=$request->eiiichecker;
        $observatorio=$request->observatorio;
        $vamola=$request->vamola;
        $wave=$request->wave;

        if($achecker==0){
            $mensaje="Sin marcar";
        }
        else{
            $mensaje="Marcado";
        }


        $paginas = explode("\n", $request->paginas);
        //for $paginas


        $num_paginas=$request->num_paginas;
        //Llamada crawler

        $periodicidad=$request->periodicidad;

        $dia=$request->dia;

        if ($periodicidad=="Semanal"){
            if ($dia<0 or $dia>6){
                return redirect("/crear-sitio")->withErrors(['dia'=>'El día debe de ser entre 0 y 6.']);
            }
        }
        elseif($periodicidad=="Mensual"){
            if ($dia<1 or $dia>31){
                return redirect("/crear-sitio")->withErrors(['dia'=>'El día debe de ser entre 1 y 31.']);
            }
        }

        $hora=$request->hora;

        //crearPagina($URL)
        //crearSitio($nombre,$dominio,$periodicidad,$hora,$dia,$automatizado,$categoria_id)

        //crearSitioHerramienta($sitio_id,$herramienta_id) -> DB::table('herramienta_sitio')

        return redirect("/crear-sitio")->with('mensaje', $hora);
    }

    public function panelModificarSitio($id){

        $s = new Sitio();
        $sitio = $s->getSitio($id);

        return view('pages.administrador.modificar-sitio', array('sitio' => $sitio));
    }

    public function modificarSitio(Request $request){
        $s = new Sitio();
        $sitio = $s->getSitio($id);

        return view('pages.administrador.modificar-sitio', array('sitio' => $sitio));
    }

    public function eliminarSitio($id){

        $s = new Sitio();
        $sitio = $s->borrarSitio($id);

        //'26', 'Test', 'test', 'Semanal', '14:30', '3', '1', '10', '5', NULL, NULL


        return redirect('gestionar-sitios');
    }

}
