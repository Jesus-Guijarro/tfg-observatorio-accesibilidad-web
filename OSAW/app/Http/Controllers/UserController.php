<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function mostrarPerfilUsuario($id){
        $user = new User();
        $usuario = $user->getUsuario($id);
        return view('pages.usuario.perfil', array('user' => $usuario));
    }
}
