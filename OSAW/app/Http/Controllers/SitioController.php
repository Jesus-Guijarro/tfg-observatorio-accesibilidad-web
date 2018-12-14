<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sitio;

class SitioController extends Controller
{
    public function listarSitios(){
        $sitio = new Sitio();
        $sitios = $sitio->getSitios();
        return view('pages.lista-sitios', array('sitios' => $sitios));
    }

    public function mostrarSitio($id){
        $s = new Sitio();
        $sitio = $s->getSitio($id);

        return view('pages.sitio', array('sitio' => $sitio));
    }

    public function busquedaSitio(Request $request){

        $nombre=$request->nombre;

        $sitio = new Sitio();
        $sitios = $sitio->getSitiosBusqueda($nombre);

        return view('pages.busqueda-sitios', array('sitios' => $sitios));
    }

}
