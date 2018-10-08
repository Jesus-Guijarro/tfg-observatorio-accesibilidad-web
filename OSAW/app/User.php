<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_usuario', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function rol() {
        return $this->belongsTo('App\Rol');
    }

    #Análisis manual
    public function paginas() {
        return $this->belongsToMany('App\Pagina')
        ->withPivot('informe','fecha_test','revisado','porcentaje_comprensible',
        'porcentaje_operable','porcentaje_perceptible','porcentaje_robusto',
        'num_errores_a','num_errores_aa','num_errores_aaa')->withTimestamps();
    }
}
