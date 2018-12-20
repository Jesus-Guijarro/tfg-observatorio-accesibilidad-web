<?php

use Illuminate\Database\Seeder;

class CategoriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias')->delete();
        
        DB::table('categorias')->insert(['descripcion' => 'Ministerios y agencias estatales']);
        DB::table('categorias')->insert(['descripcion' => 'Entidades autonómicas y locales']);
        DB::table('categorias')->insert(['descripcion' => 'Entidades públicas empresariales']);
        DB::table('categorias')->insert(['descripcion' => 'Centros universitarios públicos']);
        DB::table('categorias')->insert(['descripcion' => 'Empresas privadas']);
    }
}
