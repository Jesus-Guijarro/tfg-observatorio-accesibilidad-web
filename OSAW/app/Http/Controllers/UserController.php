<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    //Función para mostrar el perfil de usuario
    public function mostrarPerfilUsuario($id){
        $u = new User();
        $usuario = $u->getUsuario($id);
        return view('pages.usuario.perfil', array('usuario' => $usuario));
    }

    //Función encargada de mostrar el panel de modificar datos de usuarios
    public function panelModificarPerfilUsuario($id){
        $u = new User();
        $usuario = $u->getUsuario($id);
        return view('pages.usuario.modificar-perfil', array('usuario' => $usuario));
    }

    //Función para llevar a cabo los cambios del perfil de usuario
    protected function modificarPerfilUsuario(Request $request,  $id){
        
        $usuario = User::findOrFail($id);
        
        //Max:2048 -> 2MB de tamaño maximo de imagen de avatar

        $this->validate($request, [
           'nombre' => 'required|string|min:2|max:20|unique:users,nombre,'.$usuario->id,
           'email' => 'required|string|email|max:40|unique:users,email,'.$usuario->id,
           'avatar'=> 'image|mimes:jpeg,bmp,png,jpg,gif,svg|max:2048',
       ]);
        
       $usuario->nombre = $request->nombre;
       $usuario->email = $request->email;
       $usuario->biografia = $request->biografia;

       //se añade la imagen al directorio /storage/avatars/
       if($request->hasFile('avatar')){
            $usuario->avatar = '/avatars/Avatar_'.$usuario->nombre .'.'.request()->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('',$usuario->avatar);
            
            $usuario->save();
            return back()->with('mensaje','Perfil modificado con éxito.');
       }
       
       $usuario->save();
       return back()->with('mensaje','Perfil modificado con éxito.');
    }

    //Función para mostrar el panel de cambio de contraseña de usuario
    public function panelCambiarPassword($id){
        $u = new User();
        $usuario = $u->getUsuario($id);
        return view('pages.usuario.cambiar-password', array('usuario' => $usuario));
    }

    //Función que permite cambiar la contraseña de usuario
    protected function cambiarPassword(Request $request,  $id){
        
        $usuario = User::findOrFail($id);
        
        $this->validate($request, [
            'old_password' => 'required|string|min:6|max:60',
            'new_password' => 'required|string|min:6|max:60|same:new_password_confirm',
            'new_password_confirm' => 'required|string|min:6|max:60',
        ]);

        //Se comprueba si la contraseña actual coincide con la introducida en el campo de antigua contraseña
        if(Hash::check($request->old_password,$usuario->password)){
            $usuario->password = Hash::make($request->new_password);

            $usuario->save();
    
            return back()->with('mensaje','Contraseña cambiada con éxito');
        }
        else{
            return back()->withErrors(['old_password'=>'La contraseña antigua no coincide con la introducida']);
        }
        
       
   }


   //Función para gestionar los participantes del observatorio
   public function gestionarUsuarios(){
    
    
        $nombre =  Input::get('nombre');

        $usuario = new User();
        $usuarios = $usuario->getUsuariosNombre($nombre);

        return view('pages.administrador.gestionar-usuarios', array('usuarios' => $usuarios));
    }

    //Función para gestionar los participantes del observatorio
    public function listarUsuarios(){
        
        $usuario = new User();
        $usuarios = $usuario->getUsuarios();

        return view('pages.participantes', array('usuarios' => $usuarios));
    }


    public function hacerColaborador($id){

        $u = new User();
        $usuario = $u->getUsuario($id);
        $usuario->actualizarUsuarioRol($usuario->id,1);

        return redirect('gestionar-usuarios')->with('mensaje', 'El usuario "'. $usuario->nombre .'" se ha hecho colaborador');
    }

    public function hacerExperto($id){

        $u = new User();
        $usuario = $u->getUsuario($id);
        $usuario->actualizarUsuarioRol($usuario->id,2);

        return redirect('gestionar-usuarios')->with('mensaje', 'El usuario "'. $usuario->nombre .'" se ha hecho experto');
    }
}
