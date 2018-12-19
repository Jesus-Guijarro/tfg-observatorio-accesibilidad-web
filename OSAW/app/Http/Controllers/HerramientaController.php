<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Herramienta;

class HerramientaController extends Controller
{
    //Función que devuelve la vista para la gestión de las herramientas
    public function gestionarHerramientas(){

        $herramienta = new Herramienta();
        $herramientas = $herramienta->getHerramientas();

        return view('pages.administrador.gestionar-herramientas', array('herramientas' => $herramientas));
    }

    //Función para mostrar la vista de creación de una herramienta de evaluación
    public function crearHerramienta(Request $request){

        $s = new Herramienta();

        //Validaciones
        $this->validate($request, [
            'nombre' => 'required|unique:herramientas|min:2|max:40',
            'descripcion' => 'required|min:2|max:45'
        ]);

        $nombre=$request->nombre;
        $descripcion=$request->descripcion;

        //Creación de la herramienta
        $s->crearHerramienta($nombre,$descripcion);
        
        return redirect("/crear-herramienta")->with('mensaje', 'Herramienta añadida');
    }


    //Función para cargar la pantalla de modificación de una herramienta concreta
    public function panelModificarHerramienta($id){

        $h=new Herramienta();
        $herramienta = $h->getHerramienta($id);

        return view('pages.administrador.modificar-herramienta', array('herramienta' => $herramienta));

    }

    //Función para llevar a cabo la modificación de una herramiennta
    public function modificarHerramienta(Request $request, $id){

        $h=new Herramienta();

        //Validaciones
        $this->validate($request, [
            'nombre' => 'required|unique:herramientas|min:2|max:40',
            'descripcion' => 'required|min:2|max:45'
        ]);
        
        $nombre=$request->nombre;
        $descripcion=$request->descripcion;

        //Modificación de la herramienta
        $h->actualizarHerramienta($id,$nombre,$descripcion);

        return back()->with('mensaje', 'Herramienta modificada');

    }

    //Función para activar una herramienta
    public function activarHerramienta($id){

        $h = new Herramienta();
        $herramienta = $h->getHerramienta($id);

        //Se pone a estado activo
        $herramienta->activa = 1;
        $herramienta->save();

        return redirect('gestionar-herramientas')->with('mensaje', 'Herramienta "'. $herramienta->descripcion .'" activada');
    }

    //Función para desactivar una herramienta
    public function desactivarHerramienta($id){

        $h = new Herramienta();
        $herramienta = $h->getHerramienta($id);

        //El estado pasa a desactivado
        $herramienta->activa = 0;
        $herramienta->save();

        return redirect('gestionar-herramientas')->with('mensaje', 'Herramienta "'. $herramienta->descripcion .'" desactivada');
    }
    
}
