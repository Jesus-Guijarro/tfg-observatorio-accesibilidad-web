<?php

use Illuminate\Database\Seeder;

class HerramientasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('herramientas')->delete();

        DB::table('herramientas')->insert(['nombre' => 'accessmonitor',
            'activa' => true,
            'descripcion' => 'AccessMonitor']);
        DB::table('herramientas')->insert(['nombre' => 'achecker',
            'activa' => true,
            'descripcion' => 'AChecker']);
        DB::table('herramientas')->insert(['nombre' => 'eiiichecker',
            'activa' => true,
            'descripcion' => 'EIII Page Checker']);
        DB::table('herramientas')->insert(['nombre' => 'observatorio',
            'activa' => true,
            'descripcion' => 'Observatorio Accesibilidad Web UPS de Ecuador']);
        DB::table('herramientas')->insert(['nombre' => 'vamola',
            'activa' => true,
            'descripcion' => 'Vamolà']);
        DB::table('herramientas')->insert(['nombre' => 'wave',
            'activa' => true,
            'descripcion' => 'WAVE']);
    }
}
