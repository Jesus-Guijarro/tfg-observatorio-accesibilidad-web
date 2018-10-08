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
    public function accessmonitortests() {
        return $this->hasMany('App\Accessmonitortest');
    }
    public function acheckertests() {
        return $this->hasMany('App\Acheckertest');
    }
    public function eiiicheckertests() {
        return $this->hasMany('App\Eiiicheckertest');
    }
    public function examinatortests() {
        return $this->hasMany('App\Examinatortest');
    }
    public function upstests() {
        return $this->hasMany('App\Upstest');
    }
    public function vamolatests() {
        return $this->hasMany('App\Vamolatest');
    }
    public function wavetests() {
        return $this->hasMany('App\Wavetest');
    }
}
