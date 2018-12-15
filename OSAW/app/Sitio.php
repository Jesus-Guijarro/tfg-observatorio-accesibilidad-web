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

    public function getSitiosBusqueda($nombre){ # Cadena vacia -> Todos los sitios
        $sitios = Sitio::select('sitios.id','sitios.nombre','sitios.dominio','sitios.num_paginas','categorias.descripcion')->
        join('categorias','sitios.categoria_id','=','categorias.id')->
        where('nombre','like','%'.$nombre.'%')->
        orderBy('sitios.nombre','asc')->
        simplePaginate(15);
        return $sitios;
    }

    public function getSitiosCategoria($categoria_id){
        $sitios = Sitio::select('sitios.id','sitios.nombre','sitios.dominio','sitios.num_paginas','categorias.descripcion')->
        join('categorias','sitios.categoria_id','=','categorias.id')->
        where('categoria_id',$categoria_id)->
        orderBy('sitios.nombre','asc')->
        simplePaginate(15);
        return $sitios;
    }

    public function getSitios(){
        $sitios = Sitio::select('sitios.id','sitios.nombre','sitios.dominio','sitios.num_paginas','categorias.descripcion')->
        join('categorias','sitios.categoria_id','=','categorias.id')->
        orderBy('sitios.nombre','asc')->
        simplePaginate(15);

        return $sitios;
    }

    public function getNumSitios(){
        $num_sitios = Sitio::count();
        return $num_sitios;
    }

    public function getPaginasSitio($id){
        $paginas= Sitio::select('paginas.id','paginas.URL')->
        join('paginas','paginas.sitio_id','=','sitios.id')->
        where('sitios.id',$id)->get();

        return $paginas;
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
