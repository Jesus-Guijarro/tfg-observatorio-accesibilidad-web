<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    public function sendPasswordResetNotification($token)
    {
        // Your your own implementation.
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'email', 'password','rol_id','avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    public $timestamps = false;


    public function rol() {
        return $this->belongsTo('App\Rol');
    }

    #Análisis manual
    public function paginas() {
        return $this->belongsToMany('App\Pagina')
        ->withPivot('informe','fecha_test','revisado','porcentaje_comprensible',
        'porcentaje_operable','porcentaje_perceptible','porcentaje_robusto',
        'num_errores_a','num_errores_aa','num_errores_aaa')->withTimestamps();
    }

    public function getUsuario($id){
        $usuario=User::findOrFail($id);
        return $usuario;
    }

    public function getUsuarios(){
        $usuarios = User::where('rol_id','!=','3')
        ->orderBy('nombre','asc')
        ->paginate(10);
        return $usuarios;
    }

    public function getUsuariosNombre($nombre){
        $usuarios = User::select('id','nombre','avatar','rol_id')->
        where('rol_id','!=','3')->
        where('nombre','like','%'.$nombre.'%')->
        paginate(10);

        return $usuarios;
    }

    public function crearUsuario($nombre, $email, $password, $avatar){
        $user = new User();

        $user->nombre = $nombre;
        $user->email=$email;
        $user->password=$password;
        $user->avatar=$avatar;
        $user->rol_id=1;

        $user->save();

    }

    public function actualizarUsuario($id,$nombre, $email, $password, $avatar, $biografia){

        $usuario = User::findOrFail($id);

        $usuario->nombre =$nombre;
        $usuario->email =$email;
        $usuario->password =$password;
        $usuario->avatar =$avatar;
        $usuario->biografia =$biografia;

        $usuario -> save();
    }

    public function actualizarUsuarioRol($id,$rol_id){
        $usuario = User::findOrFail($id);
        $usuario->rol_id =$rol_id;

        $usuario -> save();
    }

    public function borrarUsuario($id){
        $usuario = User::findOrFail($id);
        
        $usuario ->delete();
    }
}
