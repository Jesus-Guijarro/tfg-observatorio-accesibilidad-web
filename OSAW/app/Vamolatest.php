<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vamolatest extends Model
{
    public function pagina() {
        return $this->belongsTo('App\Pagina');
    }
}
