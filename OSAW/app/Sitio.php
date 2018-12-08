<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sitio extends Model
{
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    public $timestamps = false;

    public function paginas() {
        return $this->hasMany('App\Pagina');
    }

    public function herramientas() {
        return $this->belongsToMany('App\Herramienta')->withTimestamps();
    }

    public function categoria() {
        return $this->belongsTo('App\Categoria');
    }

    public function getSitio($id){
        $sitio=Sitio::findOrFail($id);
        return $sitio;
    }

    public function getSitiosBusqueda($cadena){ # Cadena vacia -> Todos los sitios
        $sitios = Sitio::select('id','nombre','dominio','num_paginas')->
            where('nombre','like','%'.$cadena.'%')->get();
        return $sitios;
    }

    public function getSitiosCategoria($categoria_id){
        $sitios = Sitio::select('id','nombre','dominio','num_paginas')->
            where('categoria_id',$categoria_id)->get();
        return $sitios;
    }

    public function getSitios(){
        $sitios = Sitio::all();
        return $sitios;
    }

    public function crearSitio($nombre,$dominio,$periodicidad,$hora,$dia,
    $automatizado,$num_paginas,$categoria_id){
        $sitio = new Sitio();

        $sitio->nombre =$nombre;
        $sitio->dominio =$dominio;
        $sitio->periodicidad=$periodicidad;
        $sitio->hora =$hora;
        $sitio->dia =$dia;
        $sitio->automatizado =$automatizado;
        $sitio->num_paginas =$num_paginas;
        $sitio->categoria_id =$categoria_id;

        $sitio->save();
    }

    public function actualizarSitio($id,$nombre,$dominio,$periodicidad,$hora,$dia,
    $automatizado,$num_paginas,$categoria_id){

        $sitio = Sitio::findOrFail($id);

        $sitio->nombre =$nombre;
        $sitio->dominio =$dominio;
        $sitio->periodicidad=$periodicidad;
        $sitio->hora =$hora;
        $sitio->dia =$dia;
        $sitio->automatizado =$automatizado;
        $sitio->num_paginas =$num_paginas;
        $sitio->categoria_id =$categoria_id;

        $sitio -> save();
    }

    public function borrarSitio($id){
        $sitio = Sitio::findOrFail($id);
        $sitio ->delete();
    }

}
