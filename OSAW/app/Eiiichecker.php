<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Eiiichecker extends Model
{
    public function pagina() {
        return $this->belongsTo('App\Pagina');
    }

    public function getEiiichecker($id){
        $eiiichecker=Eiiichecker::findOrFail($id);
        return $eiiichecker;
    }

    public function getEiiicheckers(){
        $eiiicheckers = Eiiichecker::all();
        return $eiiicheckers;
    }

    public function getEiiicheckersSitioGraficos($sitio_id){
        $eiiicheckers = Eiiichecker::join('paginas','eiiicheckers.pagina_id','=','paginas.id')->
        where('paginas.sitio_id',$sitio_id)->
        select(DB::raw('
            sum(eiiicheckers.puntuacion)/count(*) as puntuacion,
            CAST(sum(eiiicheckers.num_problemas)/count(*) AS UNSIGNED) as num_problemas,
            CAST(sum(eiiicheckers.num_aciertos)/count(*) AS UNSIGNED) as num_aciertos,
            CAST(sum(eiiicheckers.num_problemas_a)/count(*) AS UNSIGNED) as num_problemas_a,
            CAST(sum(eiiicheckers.num_problemas_aa)/count(*) AS UNSIGNED) as num_problemas_aa,
            fecha_test'))->
        groupBy('eiiicheckers.fecha_test')->orderBy('eiiicheckers.fecha_test','asc')->get();

        return $eiiicheckers;
    }

    public function getEiiicheckersPaginaReportes($pagina_id){

        $eiiicheckers = Eiiichecker::join('paginas','eiiicheckers.pagina_id','=','paginas.id')->
        where('paginas.id',$pagina_id)->select('datos_problemas','fecha_test')->
        orderBy('fecha_test','desc')->paginate(10);

        return $eiiicheckers;
    }

    public function getEiiicheckersPaginaGraficos($pagina_id){
        $eiiicheckers = Eiiichecker::join('paginas','eiiicheckers.pagina_id','=','paginas.id')->
        where('paginas.id',$pagina_id)->
        select(DB::raw('
            sum(eiiicheckers.puntuacion)/count(*) as puntuacion,
            CAST(sum(eiiicheckers.num_problemas)/count(*) AS UNSIGNED) as num_problemas,
            CAST(sum(eiiicheckers.num_aciertos)/count(*) AS UNSIGNED) as num_aciertos,
            CAST(sum(eiiicheckers.num_problemas_a)/count(*) AS UNSIGNED) as num_problemas_a,
            CAST(sum(eiiicheckers.num_problemas_aa)/count(*) AS UNSIGNED) as num_problemas_aa,
            fecha_test'))->
        groupBy('eiiicheckers.fecha_test')->orderBy('eiiicheckers.fecha_test','asc')->get();

        return $eiiicheckers;
    }

    public function getNumEiiicheckers(){
        $num_eiiicheckers = Eiiichecker::count();
        return $num_eiiicheckers;
    }

    public function borrarEiiichecker($id){
        $eiiichecker = Eiiichecker::findOrFail($id);
        $eiiichecker ->delete();
    }
}
