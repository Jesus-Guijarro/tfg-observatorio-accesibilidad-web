<?php

use Illuminate\Database\Seeder;

class RolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rols')->delete();

        
        DB::table('rols')->insert(['descripcion' => 'Colaborador']);
        DB::table('rols')->insert(['descripcion' => 'Experto']);
        DB::table('rols')->insert(['descripcion' => 'Administrador']);
    }
}
