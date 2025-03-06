<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public function sitios() {
        return $this->hasMany('App\Sitio');
    }

    public function getCategoria($id){
        $categoria=Categoria::findOrFail($id);
        return $categoria;
    }

    public function getCategorias(){
        $categorias = Categoria::all();
        return $categorias;
    }

    public function crearCategoria($descripcion){
        $categoria = new Categoria();
        $categoria->descripcion= $descripcion;
        $categoria->save();
    }

    public function actualizarCategoria($id,$descripcion){
        $categoria = Categoria::findOrFail($id);
        $categoria->descripcion =$descripcion;
        $categoria -> save();
    }

    public function borrarCategoria($id){
        $categoria = Categoria::findOrFail($id);
        $categoria ->delete();
    }
}
