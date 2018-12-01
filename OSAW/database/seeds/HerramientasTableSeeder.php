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

        DB::table('herramientas')->insert(['descripcion' => 'accessmonitor',
            'activa' => true]);
        DB::table('herramientas')->insert(['descripcion' => 'achecker',
            'activa' => true]);
        DB::table('herramientas')->insert(['descripcion' => 'eiiichecker',
            'activa' => true]);
        DB::table('herramientas')->insert(['descripcion' => 'observatorio',
            'activa' => true]);
        DB::table('herramientas')->insert(['descripcion' => 'vamola',
            'activa' => true]);
        DB::table('herramientas')->insert(['descripcion' => 'wave',
            'activa' => true]);
    }
}
