<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accessmonitor extends Model
{
    public function pagina() {
        return $this->belongsTo('App\Pagina');
    }

    public function getAnalisis($id){

        $analisis=Accessmonitor::findOrFail($id);
        
        return $analisis;
    }

    #Función para obtener todos los analisis de una pagina web
    public function getAnalisisPorPagina($pagina_id){

        $analisis=Accessmonitor::where('pagina_id',$pagina_id)->get();

        return $analisis;
    }


    #Función para obtener el reporte con los datos de un análisis
    public function getDatosProblemas($id){

        $reporte = Accessmonitor::where('id',$id)->get();

        return $reporte;
    }
    
    #DISTINTO
    public function getPuntuacionesPagina($pagina_id){
        
        $puntuaciones=Accessmonitor::select('puntuacion','fecha_test')
            ->where('pagina_id',$pagina_id)
            ->groupBy('puntuacion', 'fecha_test')
            ->orderBy('fecha_test')
            ->get();

        return $puntuaciones;
    }

    public function getNumProblemasAPagina($pagina_id){
        
        $num_problemas_a=Accessmonitor::select('num_problemas_a','fecha_test')
            ->where('pagina_id',$pagina_id)
            ->groupBy('num_problemas_a', 'fecha_test')
            ->orderBy('fecha_test')
            ->get();

        return $num_problemas_a;
    }

    public function getNumProblemasAAPagina($pagina_id){
        
        $num_problemas_a=Accessmonitor::select('num_problemas_aa','fecha_test')
            ->where('pagina_id',$pagina_id)
            ->groupBy('num_problemas_aa', 'fecha_test')
            ->orderBy('fecha_test')
            ->get();

        return $num_problemas_a;
    }

    public function getNumProblemasAAAPagina($pagina_id){
        
        $num_problemas_a=Accessmonitor::select('num_problemas_aaa','fecha_test')
            ->where('pagina_id',$pagina_id)
            ->groupBy('num_problemas_aaa', 'fecha_test')
            ->orderBy('fecha_test')
            ->get();

        return $num_problemas_a;
    }


    public function getNumAdvertenciasAPagina($pagina_id){
        
        $num_problemas_a=Accessmonitor::select('num_advertencias_a','fecha_test')
            ->where('pagina_id',$pagina_id)
            ->groupBy('num_advertencias_a', 'fecha_test')
            ->orderBy('fecha_test')
            ->get();

        return $num_problemas_a;
    }

    public function getNumAdvertenciasAAPagina($pagina_id){
        
        $num_problemas_a=Accessmonitor::select('num_advertencias_aa','fecha_test')
            ->where('pagina_id',$pagina_id)
            ->groupBy('num_advertencias_aa', 'fecha_test')
            ->orderBy('fecha_test')
            ->get();

        return $num_problemas_a;
    }

    public function getNumAdvertenciasAAAPagina($pagina_id){
        
        $num_problemas_a=Accessmonitor::select('num_advertencias_aaa','fecha_test')
            ->where('pagina_id',$pagina_id)
            ->groupBy('num_advertencias_aaa', 'fecha_test')
            ->orderBy('fecha_test')
            ->get();

        return $num_problemas_a;
    }

}
