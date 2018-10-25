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
        
        $herramientas = array('accessmonitor' => true, 'achecker' => true, 'eiiichecker' => true, 'observatorio' => true, 
            'vamola' => true,'wave' => true);

        $json= json_encode($herramientas);
        
        DB::table('sitios')->insert([
            'nombre' => 'Ministerio de Justicia',
            'dominio' => 'http://www.mjusticia.gob.es/',
            'periodicidad_analisis' => 'Semanal',
            'num_paginas' => '10',
            'categoria_id' => '1',
            'herramientas' => "$json"]);

        DB::table('sitios')->insert([
            'nombre' => 'Agencia Estatal de Administración Tributaria',
            'dominio' => 'www.agenciatributaria.es/',
            'periodicidad_analisis' => 'Semanal',
            'num_paginas' => '10',
            'categoria_id' => '1',
            'herramientas' => "$json"]);
        
    }
}
