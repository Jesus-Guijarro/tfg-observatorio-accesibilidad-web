<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('users')->delete();

        
        DB::table('users')->insert([
        'nombre_usuario' => 'Colaborador' ,
        'email' => 'col@osaw.com' ,
        'password' => 'password' ,
        'rol_id' => '1']);

        DB::table('users')->insert([
        'nombre_usuario' => 'Experto' ,
        'email' => 'expert@osaw.com' ,
        'password' => 'password' ,
        'rol_id' => '2']);

        DB::table('users')->insert([
        'nombre_usuario' => 'Administrador' ,
        'email' => 'admin@osaw.com' ,
        'password' => 'password' ,
        'rol_id' => '3']);
        
    }
}
