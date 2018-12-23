<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Accessmonitor extends Model
{
    public function pagina() {
        return $this->belongsTo('App\Pagina');
    }

    public function getAccessmonitor($id){
        $accessmonitor=Accessmonitor::findOrFail($id);
        return $accessmonitor;
    }

    public function getAccessmonitors(){
        $accessmonitors = Accessmonitor::all();
        return $accessmonitors;
    }

    public function getAccessmonitorsSitioGraficos($sitio_id){
        $accessmonitors = Accessmonitor::join('paginas','accessmonitors.pagina_id','=','paginas.id')->
        where('paginas.sitio_id',$sitio_id)->
        select(DB::raw('
            sum(accessmonitors.puntuacion)/count(*) as puntuacion,
            CAST(sum(accessmonitors.num_problemas_a)/count(*) AS UNSIGNED) as num_problemas_a,
            CAST(sum(accessmonitors.num_problemas_aa)/count(*) AS UNSIGNED) as num_problemas_aa,
            CAST(sum(accessmonitors.num_problemas_aaa)/count(*) AS UNSIGNED) as num_problemas_aaa,
            CAST(sum(accessmonitors.num_advertencias_a)/count(*) AS UNSIGNED) as num_advertencias_a,
            CAST(sum(accessmonitors.num_advertencias_aa)/count(*) AS UNSIGNED) as num_advertencias_aa,
            CAST(sum(accessmonitors.num_advertencias_aaa)/count(*) AS UNSIGNED) as num_advertencias_aaa,
            fecha_test'))->
        groupBy('accessmonitors.fecha_test')->orderBy('accessmonitors.fecha_test','asc')->get();

        return $accessmonitors;
    }

    public function getAccessmonitorsPaginaReportes($pagina_id){

        $accessmonitors = Accessmonitor::join('paginas','accessmonitors.pagina_id','=','paginas.id')->
        where('paginas.id',$pagina_id)->select('datos_problemas','fecha_test')->
        orderBy('fecha_test','desc')->paginate(10);

        return $accessmonitors;
    }

    public function getAccessmonitorsPaginaGraficos($pagina_id){
        $accessmonitors = Accessmonitor::join('paginas','accessmonitors.pagina_id','=','paginas.id')->
        where('paginas.id',$pagina_id)->
        select(DB::raw('
            sum(accessmonitors.puntuacion)/count(*)  as puntuacion,
            CAST(sum(accessmonitors.num_problemas_a)/count(*) AS UNSIGNED) as num_problemas_a,
            CAST(sum(accessmonitors.num_problemas_aa)/count(*) AS UNSIGNED) as num_problemas_aa,
            CAST(sum(accessmonitors.num_problemas_aaa)/count(*) AS UNSIGNED) as num_problemas_aaa,
            CAST(sum(accessmonitors.num_advertencias_a)/count(*) AS UNSIGNED) as num_advertencias_a,
            CAST(sum(accessmonitors.num_advertencias_aa)/count(*) AS UNSIGNED) as num_advertencias_aa,
            CAST(sum(accessmonitors.num_advertencias_aaa)/count(*) AS UNSIGNED) as num_advertencias_aaa,
            fecha_test'))->
        groupBy('accessmonitors.fecha_test')->orderBy('accessmonitors.fecha_test','asc')->get();

        return $accessmonitors;
    }

    public function getNumAccessmonitors(){
        $num_accessmonitors = Accessmonitor::count();
        return $num_accessmonitors;
    }

    public function borrarAccessmonitor($id){
        $accessmonitor = Accessmonitor::findOrFail($id);
        $accessmonitor ->delete();
    }


}
