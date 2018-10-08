<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sitio extends Model
{
    public function paginas() {
        return $this->hasMany('App\Pagina');
    }

    public function categoria() {
        return $this->belongsTo('App\Categoria');
    }


}
