<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Sitio;
use App\Pagina;
use App\Herramienta;
use App\Categoria;
use App\Accessmonitor;
use App\Achecker;
use App\Eiiichecker;
use App\Observatorio;
use App\Vamola;
use App\Wave;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*
    public function __construct()
    {
        $this->middleware('auth');
    }*/

    //Función para mostrar la pantalla de inicio con ciertos datos de interés.
    public function mostrarInicio(){
        $sitio = new Sitio();
        $num_sitios = $sitio->getNumSitios();

        $pagina = new Pagina();
        $num_paginas = $pagina->getNumPaginas();

        $accessmonitor = new Accessmonitor();
        $num_accessmonitors = $accessmonitor->getNumAccessmonitors();

        $achecker = new Achecker();
        $num_acheckers = $achecker->getNumAcheckers();

        $eiiichecker = new Eiiichecker();
        $num_eiiicheckers = $eiiichecker->getNumEiiicheckers();

        $observatorio = new Observatorio();
        $num_observatorios = $observatorio->getNumObservatorios();

        $vamola = new Vamola();
        $num_vamolas = $vamola->getNumVamolas();

        $wave = new Wave();
        $num_waves = $wave->getNumWaves();

        $categoria = new Categoria();
        $categorias = $categoria->getCategorias();


        return view('pages.inicio', array('num_sitios' => $num_sitios,'num_paginas'=>$num_paginas
            ,'num_accessmonitors' => $num_accessmonitors,'num_acheckers' => $num_acheckers,
            'num_eiiicheckers' => $num_eiiicheckers,'num_observatorios' => $num_observatorios,'num_vamolas' => $num_vamolas,
            'num_waves' => $num_waves,'categorias'=>$categorias));

    }

}
