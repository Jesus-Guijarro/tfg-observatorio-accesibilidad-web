<?php

use Illuminate\Database\Seeder;

class PaginasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('paginas')->delete();

        
        DB::table('paginas')->insert([
            'URL' => 'http://www.mjusticia.gob.es/cs/Satellite/Portal/es/inicio',
            'sitio_id' => '1']);

        DB::table('paginas')->insert([
            'URL' => 'http://www.mjusticia.gob.es/cs/Satellite/Portal/es/atencion-ciudadano',
            'sitio_id' => '1']);

        DB::table('paginas')->insert([
            'URL' => 'http://www.mjusticia.gob.es/cs/Satellite/Portal/es/ministerio/funciones-estructura',
            'sitio_id' => '1']);

        DB::table('paginas')->insert([
            'URL' => 'http://www.mjusticia.gob.es/cs/Satellite/Portal/es/ministerio/organismos-entidades',
            'sitio_id' => '1']);

        DB::table('paginas')->insert([
            'URL' => 'http://www.mjusticia.gob.es/cs/Satellite/Portal/es/administracion-justicia/organizacion-justicia',
            'sitio_id' => '1']);

        DB::table('paginas')->insert([
            'URL' => 'http://www.mjusticia.gob.es/cs/Satellite/Portal/es/servicios-ciudadano/tramites-gestiones-personales',
            'sitio_id' => '1']);

        DB::table('paginas')->insert([
            'URL' => 'http://www.mjusticia.gob.es/cs/Satellite/Portal/es/servicios-ciudadano/empleo-publico',
            'sitio_id' => '1']);

        DB::table('paginas')->insert([
            'URL' => 'http://www.mjusticia.gob.es/cs/Satellite/Portal/es/areas-tematicas/registros',
            'sitio_id' => '1']);

        DB::table('paginas')->insert([
            'URL' => 'http://www.mjusticia.gob.es/cs/Satellite/Portal/es/actividad-legislativa/normativa',
            'sitio_id' => '1']);

        DB::table('paginas')->insert([
            'URL' => 'http://www.mjusticia.gob.es/cs/Satellite/Portal/es/justicia-espana/organizacion',
            'sitio_id' => '1']);
    }
}
