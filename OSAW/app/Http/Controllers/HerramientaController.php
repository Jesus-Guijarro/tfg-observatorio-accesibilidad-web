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

        $this->validate($request, [
            'nombre' => 'required|unique:herramientas|min:2|max:40',
            'descripcion' => 'required|min:2|max:45'
        ]);

        $nombre=$request->nombre;
        $descripcion=$request->descripcion;

        $s->crearHerramienta($nombre,$descripcion);
        
        return redirect("/crear-herramienta")->with('mensaje', 'Herramienta añadida');
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
