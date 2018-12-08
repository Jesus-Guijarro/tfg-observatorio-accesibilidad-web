<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    public function users() {
        return $this->hasMany('App\User');
    }

    public function getRol($id){
        $rol=Rol::findOrFail($id);
        return $rol;
    }

    public function getRoles(){
        $roles = Rol::all();
        return $roles;
    }

    public function crearRol($descripcion){
        $rol = new Rol();
        $rol->descripcion= $descripcion;
        $rol->save();
    }

    public function actualizarRol($id,$descripcion){
        $rol = Rol::findOrFail($id);
        $rol->descripcion =$descripcion;
        $rol -> save();
    }

    public function borrarRol($id){
        $rol = Rol::findOrFail($id);
        $rol ->delete();
    }

}
