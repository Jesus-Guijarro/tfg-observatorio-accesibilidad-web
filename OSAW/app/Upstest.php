<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upstest extends Model
{
    public function pagina() {
        return $this->belongsTo('App\Pagina');
    }
}
