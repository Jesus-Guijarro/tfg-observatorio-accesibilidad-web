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
            'nombre' => 'required|unique:herramientas|min:2|max:40',
            'descripcion' => 'required|min:2|max:45'
        ]);

        $nombre=$request->nombre;
        $descripcion=$request->descripcion;

        $s->crearHerramienta($nombre,$descripcion);

        return redirect("/gestionar-sitios");
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
