<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    
    protected function modificarPerfil(Request $request,  $id){
        
        
         $this->validate($request, [
            'nombre' => 'required|unique:users|string|min:2|max:20',
            'email' => 'required|unique:users|string|email|max:40',
            'password' => 'required|string|min:6|max:60|confirmed',
            'avatar'=> 'image|mimes:jpeg,bmp,png,jpg,gif|max:2048',
            'biografia' => 'string',
        ]);
         
        $u = new User();
        $usuario = $u->getUsuario($id);

        $nombre = $request->nombre;
        $email = $request->email;
        $password = Hash::make($request->password);
        $biografia = $request->biografia;

        $request->avatar->storeAs('avatars',$avatarName);
        $avatar = 'avatar_'.$nombre.'.'.request()->avatar->getClientOriginalExtension();
        

        $usuario->actualizarPerfil($id,$nombre,$email,$password,$avatar,$biografia);
        
        return back()->with('mensaje','Perfil modificado con éxito.');

    }


    public function mostrarPerfilUsuario($id){
        $u = new User();
        $usuario = $u->getUsuario($id);
        return view('pages.usuario.perfil', array('usuario' => $usuario));
    }

    public function panelModificarPerfilUsuario($id){
        $u = new User();
        $usuario = $u->getUsuario($id);
        return view('pages.usuario.modificar-perfil', array('usuario' => $usuario));
    }

    public function modificarPerfilUsuario(Request $request, $id){
        $u = new User();
        $usuario = $u->getUsuario($id);
        return view('pages.usuario.modificar-perfil', array('usuario' => $usuario));
    }

}
