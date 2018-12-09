<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Wave extends Model
{
    public function pagina() {
        return $this->belongsTo('App\Pagina');
    }
}
