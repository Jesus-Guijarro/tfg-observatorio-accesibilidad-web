<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Herramienta;

class HerramientaController extends Controller
{
    public function gestionarHerramientas(){

        $herramienta = new Herramienta();
        $herramientas = $herramienta->getHerramientas();

        return view('pages.administrador.gestionar-herramientas', array('herramientas' => $herramientas));
    }

    public function crearHerramienta(Request $request){
        $s = new Herramienta();
        $herramienta = $s->getHerramienta($id);

        return view('pages.administrador.crear-herramienta', array('herramienta' => $herramienta));
    }

    public function activarHerramienta($id){

        $h = new Herramienta();
        $herramienta = $h->getHerramienta($id);

        $herramienta->activa = 1;
        $herramienta->save();

        return redirect('gestionar-herramientas');
    }

    public function desactivarHerramienta($id){

        $h = new Herramienta();
        $herramienta = $h->getHerramienta($id);

        $herramienta->activa = 0;
        $herramienta->save();

        return redirect('gestionar-herramientas');
    }
    
}
