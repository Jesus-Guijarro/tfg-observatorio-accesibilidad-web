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
        'nombre' => 'Colaborador' ,
        'email' => 'col@osaw.com' ,
        'password' => bcrypt('password') ,
        'rol_id' => '1']);

        DB::table('users')->insert([
        'nombre' => 'Experto' ,
        'email' => 'expert@osaw.com' ,
        'password' => bcrypt('password') ,
        'rol_id' => '2']);

        DB::table('users')->insert([
        'nombre' => 'Administrador' ,
        'email' => 'admin@osaw.com' ,
        'password' => bcrypt('password') ,
        'rol_id' => '3']);
        
    }
}
