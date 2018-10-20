<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eiiichecker extends Model
{
    public function pagina() {
        return $this->belongsTo('App\Pagina');
    }
}
