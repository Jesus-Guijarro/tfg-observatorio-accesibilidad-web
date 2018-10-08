<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public function sitios() {
        return $this->hasMany('App\Sitio');
    }
}
