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

        return view('pages.sitio', array('sitio' => $sitio, 'dia'=>$dia,'paginas' => $paginas));
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


    ###

    public function gestionarSitios(){

        return view('pages.administrador.gestionar-sitios', array('sitios' => $sitios));
    }

    public function crearSitio(Request $request){
        $s = new Sitio();
        $sitio = $s->getSitio($id);

        return view('pages.administrador.crear-sitio', array('sitio' => $sitio));
    }

    public function modificarSitio(Request $request){
        $s = new Sitio();
        $sitio = $s->getSitio($id);

        return view('pages.administrador.modificar-sitio', array('sitio' => $sitio));
    }

}
