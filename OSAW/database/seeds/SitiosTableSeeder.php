<?php

use Illuminate\Database\Seeder;

class SitiosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sitios')->delete();

        
        DB::table('sitios')->insert([
            'nombre' => 'Ministerio de Justicia',
            'URL_principal' => 'http://www.mjusticia.gob.es/cs/Satellite/Portal/es/inicio',
            'periodicidad_analisis' => 'Semanal',
            'numero_paginas' => '10',
            'categoria_id' => '1']);
        
    }
}
