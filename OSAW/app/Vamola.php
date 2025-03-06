<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vamola extends Model
{
    public function pagina() {
        return $this->belongsTo('App\Pagina');
    }

    public function getVamola($id){
        $vamola=Vamola::findOrFail($id);
        return $vamola;
    }

    public function getVamolas(){
        $vamolas = Vamola::all();
        return $vamolas;
    }

    public function getVamolasSitioGraficos($sitio_id){
        $vamolas = Vamola::join('paginas','vamolas.pagina_id','=','paginas.id')->
        where('paginas.sitio_id',$sitio_id)->
        select(DB::raw('
            CAST(sum(vamolas.num_problemas_conocidos)/count(*) AS UNSIGNED) as num_problemas_conocidos,
            CAST(sum(vamolas.num_problemas_potenciales)/count(*) AS UNSIGNED) as  num_problemas_potenciales,
            CAST(sum(vamolas.num_problemas_conocidos_a)/count(*) AS UNSIGNED) as num_problemas_conocidos_a,
            CAST(sum(vamolas.num_problemas_conocidos_aa)/count(*) AS UNSIGNED) as num_problemas_conocidos_aa,
            CAST(sum(vamolas.num_problemas_conocidos_aaa)/count(*) AS UNSIGNED) as num_problemas_conocidos_aaa,
            CAST(sum(vamolas.num_problemas_potenciales_a)/count(*) AS UNSIGNED) as num_problemas_potenciales_a,
            CAST(sum(vamolas.num_problemas_potenciales_aa)/count(*) AS UNSIGNED) as num_problemas_potenciales_aa,
            CAST(sum(vamolas.num_problemas_potenciales_aaa)/count(*) AS UNSIGNED) as num_problemas_potenciales_aaa,
            fecha_test'))->
        groupBy('vamolas.fecha_test')->orderBy('vamolas.fecha_test','asc')->get();

        return $vamolas;
    }

    public function getVamolasPaginaReportes($pagina_id){

        $vamolas = Vamola::join('paginas','vamolas.pagina_id','=','paginas.id')->
        where('paginas.id',$pagina_id)->select('datos_problemas','fecha_test')->
        orderBy('fecha_test','desc')->paginate(10);

        return $vamolas;
    }

    public function getVamolasPaginaGraficos($pagina_id){
        $vamolas = Vamola::join('paginas','vamolas.pagina_id','=','paginas.id')->
        where('paginas.id',$pagina_id)->
        select(DB::raw('
            CAST(sum(vamolas.num_problemas_conocidos)/count(*) AS UNSIGNED) as num_problemas_conocidos,
            CAST(sum(vamolas.num_problemas_potenciales)/count(*) AS UNSIGNED) as  num_problemas_potenciales,
            CAST(sum(vamolas.num_problemas_conocidos_a)/count(*) AS UNSIGNED) as num_problemas_conocidos_a,
            CAST(sum(vamolas.num_problemas_conocidos_aa)/count(*) AS UNSIGNED) as num_problemas_conocidos_aa,
            CAST(sum(vamolas.num_problemas_conocidos_aaa)/count(*) AS UNSIGNED) as num_problemas_conocidos_aaa,
            CAST(sum(vamolas.num_problemas_potenciales_a)/count(*) AS UNSIGNED) as num_problemas_potenciales_a,
            CAST(sum(vamolas.num_problemas_potenciales_aa)/count(*) AS UNSIGNED) as num_problemas_potenciales_aa,
            CAST(sum(vamolas.num_problemas_potenciales_aaa)/count(*) AS UNSIGNED) as num_problemas_potenciales_aaa,
            fecha_test'))->
        groupBy('vamolas.fecha_test')->orderBy('vamolas.fecha_test','asc')->get();

        return $vamolas;
    }

    public function getNumVamolas(){
        $num_vamolas = Vamola::count();
        return $num_vamolas;
    }

    public function borrarVamola($id){
        $vamola = Vamola::findOrFail($id);
        $vamola ->delete();
    }
}
