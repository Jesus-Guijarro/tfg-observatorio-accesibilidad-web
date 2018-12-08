<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Herramienta extends Model
{

    public function sitios() {
        return $this->belongsToMany('App\Sitio')->withTimestamps();
    }

    public $timestamps = false;

    public function getHerramienta($id){
        $herramienta=Herramienta::findOrFail($id);
        return $herramienta;
    }

    public function getHerramientas(){
        $herramientas = Herramienta::all();
        return $herramientas;
    }

    public function getHerramientasActivas(){
        $herramientas = Herramienta::select('id','descripcion')->
            where('activa',true)->get();
        return $herramientas;
    }

    public function crearHerramienta($descripcion){
        $herramienta = new Herramienta();
        $herramienta->descripcion= $descripcion;
        $herramienta->activa = false;
        $herramienta->save();
    }

    public function actualizarHerramienta($id,$descripcion,$activa){
        $herramienta = Herramienta::findOrFail($id);
        $herramienta->descripcion =$descripcion;
        $herramienta ->activa = $activa;
        $herramienta -> save();
    }

    public function borrarHerramienta($id){
        $herramienta = Herramienta::findOrFail($id);
        $herramienta ->delete();
    }
}
