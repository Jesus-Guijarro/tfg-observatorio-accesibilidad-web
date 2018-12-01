<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sitio extends Model
{
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    public function paginas() {
        return $this->hasMany('App\Pagina');
    }

    public function categoria() {
        return $this->belongsTo('App\Categoria');
    }


}
