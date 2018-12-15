<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
    public function sitio() {
        return $this->belongsTo('App\Sitio');
    }

    #Análisis manual
    public function users() {
        return $this->belongsToMany('App\User')
        ->withPivot('informe','fecha_test','revisado','porcentaje_comprensible',
        'porcentaje_operable','porcentaje_perceptible','porcentaje_robusto',
        'num_errores_a','num_errores_aa','num_errores_aaa')->withTimestamps();
    }

    #Herramientas
    public function accessmonitors() {
        return $this->hasMany('App\Accessmonitor');
    }
    public function acheckers() {
        return $this->hasMany('App\Achecker');
    }
    public function eiiicheckers() {
        return $this->hasMany('App\Eiiichecker');
    }
    public function observatorios() {
        return $this->hasMany('App\Observatorio');
    }
    public function vamolas() {
        return $this->hasMany('App\Vamola');
    }
    public function waves() {
        return $this->hasMany('App\Wave');
    }

    #
    public function getPagina($id){
        $pagina=Pagina::findOrFail($id);
        return $pagina;
    }

    public function getSitioPagina($id){
        $sitio= Pagina::select('sitio.id','sitio.nombre')->
        join('sitios','sitios.pagina_id','=','paginas.id')->
        where('paginas.id',$id)->get();

        return $sitio;
    }

    public function getNumPaginas(){
        $num_paginas = Pagina::count();
        return $num_paginas;
    }

    public function crearPagina($URL){
        $pagina = new Pagina();
        $pagina->URL= $URL;
        $pagina->save();
    }

    public function actualizarPagina($id,$URL){
        $pagina = Pagina::findOrFail($id);
        $pagina->URL =$URL;
        $pagina -> save();
    }

    public function borrarPagina($id){
        $pagina = Pagina::findOrFail($id);
        $pagina ->delete();
    }


}
