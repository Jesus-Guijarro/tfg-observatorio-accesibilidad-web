<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Achecker extends Model
{
    public function pagina() {
        return $this->belongsTo('App\Pagina');
    }

    public function getAchecker($id){
        $achecker=Achecker::findOrFail($id);
        return $achecker;
    }

    public function getAcheckers(){
        $acheckers = Achecker::all();
        return $acheckers;
    }
    
    public function getAcheckersSitioGraficos($sitio_id){
        $acheckers = Achecker::join('paginas','acheckers.pagina_id','=','paginas.id')->
        where('paginas.sitio_id',$sitio_id)->
        select(DB::raw('
            CAST(sum(acheckers.num_problemas_conocidos)/count(*) AS UNSIGNED) as num_problemas_conocidos,
            CAST(sum(acheckers.num_problemas_potenciales)/count(*) AS UNSIGNED) as  num_problemas_potenciales,
            CAST(sum(acheckers.num_problemas_conocidos_a)/count(*) AS UNSIGNED) as num_problemas_conocidos_a,
            CAST(sum(acheckers.num_problemas_conocidos_aa)/count(*) AS UNSIGNED) as num_problemas_conocidos_aa,
            CAST(sum(acheckers.num_problemas_conocidos_aaa)/count(*) AS UNSIGNED) as num_problemas_conocidos_aaa,
            CAST(sum(acheckers.num_problemas_potenciales_a)/count(*) AS UNSIGNED) as num_problemas_potenciales_a,
            CAST(sum(acheckers.num_problemas_potenciales_aa)/count(*) AS UNSIGNED) as num_problemas_potenciales_aa,
            CAST(sum(acheckers.num_problemas_potenciales_aaa)/count(*) AS UNSIGNED) as num_problemas_potenciales_aaa,
            fecha_test'))->
        groupBy('acheckers.fecha_test')->orderBy('acheckers.fecha_test','asc')->get();

        return $acheckers;
    }

    public function getAcheckersPaginaReportes($pagina_id){

        $acheckers = Achecker::join('paginas','acheckers.pagina_id','=','paginas.id')->
        where('paginas.id',$pagina_id)->select('datos_problemas','fecha_test')->
        orderBy('fecha_test','desc')->paginate(10);

        return $acheckers;
    }

    public function getAcheckersPaginaGraficos($pagina_id){
        $acheckers = Achecker::join('paginas','acheckers.pagina_id','=','paginas.id')->
        where('paginas.id',$pagina_id)->
        select(DB::raw('
            CAST(sum(acheckers.num_problemas_conocidos)/count(*) AS UNSIGNED) as num_problemas_conocidos,
            CAST(sum(acheckers.num_problemas_potenciales)/count(*) AS UNSIGNED) as  num_problemas_potenciales,
            CAST(sum(acheckers.num_problemas_conocidos_a)/count(*) AS UNSIGNED) as num_problemas_conocidos_a,
            CAST(sum(acheckers.num_problemas_conocidos_aa)/count(*) AS UNSIGNED) as num_problemas_conocidos_aa,
            CAST(sum(acheckers.num_problemas_conocidos_aaa)/count(*) AS UNSIGNED) as num_problemas_conocidos_aaa,
            CAST(sum(acheckers.num_problemas_potenciales_a)/count(*) AS UNSIGNED) as num_problemas_potenciales_a,
            CAST(sum(acheckers.num_problemas_potenciales_aa)/count(*) AS UNSIGNED) as num_problemas_potenciales_aa,
            CAST(sum(acheckers.num_problemas_potenciales_aaa)/count(*) AS UNSIGNED) as num_problemas_potenciales_aaa,
            fecha_test'))->
        groupBy('acheckers.fecha_test')->orderBy('acheckers.fecha_test','asc')->get();

        return $acheckers;
    }

    public function getNumAcheckers(){
        $num_acheckers = Achecker::count();
        return $num_acheckers;
    }

    public function borrarAchecker($id){
        $achecker = Achecker::findOrFail($id);
        $achecker ->delete();
    }










}
