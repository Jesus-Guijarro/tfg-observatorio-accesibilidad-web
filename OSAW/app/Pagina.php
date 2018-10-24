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
}
