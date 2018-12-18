<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    


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

    protected function modificarPerfilUsuario(Request $request,  $id){
        
        $usuario = User::findOrFail($id);
        
        $this->validate($request, [
           'nombre' => 'required|string|min:2|max:20|unique:users,nombre,'.$usuario->id,
           'email' => 'required|string|email|max:40|unique:users,email,'.$usuario->id,
           'avatar'=> 'image|mimes:jpeg,bmp,png,jpg,gif|max:2048',
       ]);
        
       
       

       $usuario->nombre = $request->nombre;
       $usuario->email = $request->email;
       $usuario->biografia = $request->biografia;

       if($request->hasFile('avatar')){
            $usuario->avatar = '/avatars/avatar_'.$usuario->nombre . date('Y-m-d H:i:s') .'.'.request()->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('',$usuario->avatar);
            

            $usuario->save();
            return back()->with('mensaje','Perfil modificado con éxito.');
       }
       
       $usuario->save();
       return back()->with('mensaje','Perfil modificado con éxito.');
   }

}
