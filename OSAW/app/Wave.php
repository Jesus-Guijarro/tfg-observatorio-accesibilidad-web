<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wave extends Model
{
    public function pagina() {
        return $this->belongsTo('App\Pagina');
    }

    public function getWave($id){
        $wave=Wave::findOrFail($id);
        return $wave;
    }

    public function getWaves(){
        $waves = Wave::all();
        return $waves;
    }

    #num_problemas, num_advertencias, num_caracteristicas, num_elem_ARIA, 
    #num_problemas_contraste,fecha_test

    public function getWavesSitioGraficos($sitio_id){
        $waves = Wave::join('paginas','waves.pagina_id','=','paginas.id')->
        where('paginas.sitio_id',$sitio_id)->
        select(DB::raw('
            CAST(sum(waves.num_problemas)/count(*) AS UNSIGNED) as num_problemas,
            CAST(sum(waves.num_advertencias)/count(*) AS UNSIGNED) as num_advertencias,
            CAST(sum(waves.num_caracteristicas)/count(*) AS UNSIGNED) as num_caracteristicas,
            CAST(sum(waves.num_elem_ARIA)/count(*) AS UNSIGNED) as num_elem_ARIA,
            CAST(sum(waves.num_problemas_contraste)/count(*) AS UNSIGNED) as num_problemas_contraste,
            fecha_test'))->
        groupBy('waves.fecha_test')->orderBy('waves.fecha_test','asc')->get();

        return $waves;
    }

    public function getWavesPaginaReportes($pagina_id){

        $waves = Wave::join('paginas','waves.pagina_id','=','paginas.id')->
        where('paginas.id',$pagina_id)->select('datos_problemas','fecha_test')->
        orderBy('fecha_test','desc')->paginate(10);

        return $waves;
    }

    public function getWavesPaginaGraficos($pagina_id){
        $waves = Wave::join('paginas','waves.pagina_id','=','paginas.id')->
        where('paginas.id',$pagina_id)->
        select(DB::raw('
            CAST(sum(waves.num_problemas)/count(*)AS UNSIGNED) as num_problemas,
            CAST(sum(waves.num_advertencias)/count(*)AS UNSIGNED) as num_advertencias,
            CAST(sum(waves.num_caracteristicas)/count(*)AS UNSIGNED) as num_caracteristicas,
            CAST(sum(waves.num_elem_ARIA)/count(*)AS UNSIGNED) as num_elem_ARIA,
            CAST(sum(waves.num_problemas_contraste)/count(*)AS UNSIGNED) as num_problemas_contraste,
            fecha_test'))->
        groupBy('waves.fecha_test')->orderBy('waves.fecha_test','asc')->get();

        return $waves;
    }

    public function getNumWaves(){
        $num_waves = Wave::count();
        return $num_waves;
    }

    public function borrarWave($id){
        $wave = Wave::findOrFail($id);
        $wave ->delete();
    }
}
