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
        $herramientas = Herramienta::select('id','descripcion','nombre')->
            where('activa',true)->get();
        return $herramientas;
    }

    public function getHerramientasSitio($id){
        $hs = Herramienta::join('herramienta_sitio', 'herramientas.id', '=', 'herramienta_sitio.herramienta_id')->
        where('herramienta_sitio.sitio_id','=',$id)->
        where('herramientas.activa',true)->
        select('herramientas.id')->
        get();

        $herramientas = array();

        foreach ($hs as $herramienta) {
            array_push($herramientas,$herramienta["id"]);
        }
        
        return $herramientas;
    }

    public function crearHerramienta($nombre,$descripcion){
        $herramienta = new Herramienta();
        $herramienta->nombre= $nombre;
        $herramienta->descripcion= $descripcion;
        $herramienta->activa = false;
        $herramienta->save();

    }

    public function actualizarHerramienta($id,$nombre,$descripcion){
        $herramienta = Herramienta::findOrFail($id);
        $herramienta->nombre= $nombre;
        $herramienta->descripcion =$descripcion;
        $herramienta-> save();
    }

    public function borrarHerramienta($id){
        $herramienta = Herramienta::findOrFail($id);
        $herramienta->delete();
    }
}
