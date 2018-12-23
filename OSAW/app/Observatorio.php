<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Observatorio extends Model
{
    public function pagina() {
        return $this->belongsTo('App\Pagina');
    }

    public function getObservatorio($id){
        $observatorio=Observatorio::findOrFail($id);
        return $observatorio;
    }

    public function getObservatorios(){
        $observatorios = Observatorio::all();
        return $observatorios;
    }

    public function getObservatoriosSitioGraficos($sitio_id){
        $observatorios = Observatorio::join('paginas','observatorios.pagina_id','=','paginas.id')->
        where('paginas.sitio_id',$sitio_id)->
        select(DB::raw('
            CAST(sum(observatorios.porcentaje_comprensible)/count(*) AS UNSIGNED) as porcentaje_comprensible,
            CAST(sum(observatorios.porcentaje_operable)/count(*) AS UNSIGNED) as porcentaje_operable,
            CAST(sum(observatorios.porcentaje_perceptible)/count(*) AS UNSIGNED) as porcentaje_perceptible,
            CAST(sum(observatorios.porcentaje_robusto)/count(*) AS UNSIGNED) as porcentaje_robusto,
            CAST(sum(observatorios.num_problemas_comprensible)/count(*) AS UNSIGNED) as num_problemas_comprensible,
            CAST(sum(observatorios.num_problemas_operable)/count(*) AS UNSIGNED) as num_problemas_operable,
            CAST(sum(observatorios.num_problemas_perceptible)/count(*) AS UNSIGNED) as num_problemas_perceptible,
            CAST(sum(observatorios.num_problemas_robusto)/count(*) AS UNSIGNED) as num_problemas_robusto,
            CAST(sum(observatorios.num_advertencias_comprensible)/count(*) AS UNSIGNED) as num_advertencias_comprensible,
            CAST(sum(observatorios.num_advertencias_operable)/count(*) AS UNSIGNED) as num_advertencias_operable,
            CAST(sum(observatorios.num_advertencias_perceptible)/count(*) AS UNSIGNED) as num_advertencias_perceptible,
            CAST(sum(observatorios.num_advertencias_robusto)/count(*) AS UNSIGNED) as num_advertencias_robusto,
            fecha_test'))->
        groupBy('observatorios.fecha_test')->orderBy('observatorios.fecha_test','asc')->get();

        return $observatorios;
    }

    public function getObservatoriosPaginaReportes($pagina_id){

        $observatorios = Observatorio::join('paginas','observatorios.pagina_id','=','paginas.id')->
        where('paginas.id',$pagina_id)->select('datos_problemas','fecha_test')->
        orderBy('fecha_test','desc')->paginate(10);

        return $observatorios;
    }

    public function getObservatoriosPaginaGraficos($pagina_id){
        $observatorios = Observatorio::join('paginas','observatorios.pagina_id','=','paginas.id')->
        where('paginas.id',$pagina_id)->
        select(DB::raw('
            CAST(sum(observatorios.porcentaje_comprensible)/count(*) AS UNSIGNED) as porcentaje_comprensible,
            CAST(sum(observatorios.porcentaje_operable)/count(*) AS UNSIGNED) as porcentaje_operable,
            CAST(sum(observatorios.porcentaje_perceptible)/count(*) AS UNSIGNED) as porcentaje_perceptible,
            CAST(sum(observatorios.porcentaje_robusto)/count(*) AS UNSIGNED) as porcentaje_robusto,
            CAST(sum(observatorios.num_problemas_comprensible)/count(*) AS UNSIGNED) as num_problemas_comprensible,
            CAST(sum(observatorios.num_problemas_operable)/count(*) AS UNSIGNED) as num_problemas_operable,
            CAST(sum(observatorios.num_problemas_perceptible)/count(*) AS UNSIGNED) as num_problemas_perceptible,
            CAST(sum(observatorios.num_problemas_robusto)/count(*) AS UNSIGNED) as num_problemas_robusto,
            CAST(sum(observatorios.num_advertencias_comprensible)/count(*) AS UNSIGNED) as num_advertencias_comprensible,
            CAST(sum(observatorios.num_advertencias_operable)/count(*) AS UNSIGNED) as num_advertencias_operable,
            CAST(sum(observatorios.num_advertencias_perceptible)/count(*) AS UNSIGNED) as num_advertencias_perceptible,
            CAST(sum(observatorios.num_advertencias_robusto)/count(*) AS UNSIGNED) as num_advertencias_robusto,
            fecha_test'))->
        groupBy('observatorios.fecha_test')->orderBy('observatorios.fecha_test','asc')->get();

        return $observatorios;
    }

    public function getNumObservatorios(){
        $num_observatorios = Observatorio::count();
        return $num_observatorios;
    }

    public function borrarObservatorio($id){
        $observatorio = Observatorio::findOrFail($id);
        $observatorio ->delete();
    }
}
