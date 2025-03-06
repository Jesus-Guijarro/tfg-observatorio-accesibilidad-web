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

    public function getSitios(){
        $sitios = Sitio::select('sitios.id','sitios.nombre','sitios.dominio','categorias.descripcion')->
        join('categorias','sitios.categoria_id','=','categorias.id')->
        orderBy('sitios.nombre','asc')->
        paginate(10);

        return $sitios;
    }

    public function getSitiosBusqueda($nombre){ # Cadena vacia -> Todos los sitios
        $sitios = Sitio::select('sitios.id','sitios.nombre','sitios.dominio','categorias.descripcion')->
        join('categorias','sitios.categoria_id','=','categorias.id')->
        where('nombre','like','%'.$nombre.'%')->
        orderBy('sitios.nombre','asc')->
        paginate(10);
        return $sitios;
    }

    public function getSitiosCategoria($categoria_id){
        $sitios = Sitio::select('sitios.id','sitios.nombre','sitios.dominio','categorias.descripcion')->
        join('categorias','sitios.categoria_id','=','categorias.id')->
        where('categoria_id',$categoria_id)->
        orderBy('sitios.nombre','asc')->
        paginate(10);
        return $sitios;
    }

    public function getSitiosCategoriaNombre($nombre,$categoria_id){
        $sitios = Sitio::select('sitios.id','sitios.nombre','sitios.dominio','categorias.descripcion')->
        join('categorias','sitios.categoria_id','=','categorias.id')->
        where('categoria_id',$categoria_id)->
        where('nombre','like','%'.$nombre.'%')->
        orderBy('sitios.nombre','asc')->
        paginate(10);
        return $sitios;
    }

    public function getNumSitios(){
        $num_sitios = Sitio::count();
        return $num_sitios;
    }

    public function getPaginasSitio($id){
        $paginas= Sitio::select('paginas.id','paginas.URL')->
        join('paginas','paginas.sitio_id','=','sitios.id')->
        where('sitios.id',$id)->paginate(10);

        return $paginas;
    }

    public function getPaginasSitioURL($id,$url){
        $paginas= Sitio::select('paginas.id','paginas.URL')->
        join('paginas','paginas.sitio_id','=','sitios.id')->
        where('sitios.id',$id)->
        where('paginas.URL','like','%'.$url.'%')->
        paginate(10);

        return $paginas;
    }

    public function getDiaAnalisis($id){
        $sitio= Sitio::findOrFail($id);

        if($sitio->periodicidad=="Semanal"){

            $dias = array(0 => "Domingo",1 => "Lunes",2 => "Martes",3 => "Miércoles",4 => "Jueves",5 => "Viernes",6 => "Sábado");

            $dia = $dias[$sitio->dia];
        }
        else{
            $dia = $sitio->dia;
        }

        return $dia;
    }

    public function getHerramientasSitio($id){
        
        $s = new Sitio();
        $sitio = $s->getSitio($id);

        $hs_sitio = $sitio->herramientas;
        $herramientas_sitio = array();
        foreach($hs_sitio as $h_sitio){
            array_push($herramientas_sitio, $h_sitio['id']);
        }

        return $herramientas_sitio;
    }

    public function crearSitio($nombre,$dominio,$periodicidad,$hora,$dia,$automatizado,$categoria_id){
        $sitio = new Sitio();

        $sitio->nombre =$nombre;
        $sitio->dominio =$dominio;
        $sitio->periodicidad=$periodicidad;
        $sitio->hora =$hora;
        $sitio->dia =$dia;
        $sitio->automatizado =$automatizado;
        $sitio->categoria_id =$categoria_id;

        $sitio->save();

        $id=$sitio->id;

        return $id;
    }

    public function actualizarSitio($id,$nombre,$dominio,$periodicidad,$hora,$dia,$automatizado,$categoria_id){

        $sitio = Sitio::findOrFail($id);

        $sitio->nombre =$nombre;
        $sitio->dominio =$dominio;
        $sitio->periodicidad=$periodicidad;
        $sitio->hora =$hora;
        $sitio->dia =$dia;
        $sitio->automatizado =$automatizado;
        $sitio->categoria_id =$categoria_id;

        $sitio -> save();
    }

    public function borrarSitio($id){
        $sitio = Sitio::findOrFail($id);
        $sitio ->delete();
    }



}
