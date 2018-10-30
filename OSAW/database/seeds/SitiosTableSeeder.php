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
        
        $json = array('accessmonitor' => true, 'achecker' => true, 'eiiichecker' => true, 'observatorio' => true, 
            'vamola' => true,'wave' => true);

        $herramientas= json_encode($json);
        
        #Sitios con todas las herramientas asignadas
        DB::table('sitios')->insert([
            [
                'nombre' => 'Ministerio de Justicia',
                'dominio' => 'www.mjusticia.gob.es',
                'periodicidad' => 'Diario',
                'hora'=>'13:00',
                'dia' => '0',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '1',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Agencia Estatal de Administración Tributaria',
                'dominio' => 'www.agenciatributaria.es',
                'periodicidad' => 'Semanal',
                'hora'=>'13:00',
                'dia' => '1',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '1',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Generalitat Valenciana',
                'dominio' => 'www.gva.es',
                'periodicidad' => 'Semanal',
                'hora'=>'13:00',
                'dia' => '2',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '2',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Ayuntamiento de Alicante',
                'dominio' => 'www.alicante.es',
                'periodicidad' => 'Semanal',
                'hora'=>'13:00',
                'dia' => '3',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '2',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Red Nacional de los Ferrocarriles Españoles (RENFE)',
                'dominio' => 'www.renfe.com',
                'periodicidad' => 'Semanal',
                'hora'=>'13:00',
                'dia' => '4',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '3',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Centro para el Desarrollo Tecnológico Industrial (CDTI)',
                'dominio' => 'www.cdti.es',
                'periodicidad' => 'Semanal',
                'hora'=>'13:00',
                'dia' => '5',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '3',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Universitat Politècnica de València (UPV)',
                'dominio' => 'www.upv.es',
                'periodicidad' => 'Semanal',
                'hora'=>'13:00',
                'dia' => '6',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '4',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Universidad de Alicante (UA)',
                'dominio' => 'web.ua.es',
                'periodicidad' => 'Semanal',
                'hora'=>'14:00',
                'dia' => '0',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '4',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Endesa',
                'dominio' => '/www.endesaclientes.com',
                'periodicidad' => 'Semanal',
                'hora'=>'14:00',
                'dia' => '1',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '5',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Iberdrola',
                'dominio' => 'www.iberdrola.es',
                'periodicidad' => 'Semanal',
                'hora'=>'14:00',
                'dia' => '2',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '5',
                'herramientas' => "$herramientas"
            ]
            ]);
        
        #Ministerios y agencias estatales
        $json = array('accessmonitor' => false, 'achecker' => true, 'eiiichecker' => false, 
        'observatorio' => true, 'vamola' => false,'wave' => true);

        $herramientas= json_encode($json);

        DB::table('sitios')->insert([
            [
                'nombre' => 'Ministerio de Sanidad, Consumo y Bienestar Social',
                'dominio' => 'www.mscbs.gob.es',
                'periodicidad' => 'Diario',
                'hora'=>'14:00',
                'dia' => '3',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '1',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Ministerio de Ciencia, Innovación y Universidades',
                'dominio' => 'www.ciencia.gob.es',
                'periodicidad' => 'Semanal',
                'hora'=>'14:00',
                'dia' => '4',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '1',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Ministerio de Educación, Cultura y Deporte',
                'dominio' => 'www.mecd.gob.es',
                'periodicidad' => 'Semanal',
                'hora'=>'14:00',
                'dia' => '5',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '1',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Ministerio de Trabajo, Migraciones y Seguridad Social',
                'dominio' => 'www.mitramiss.gob.es',
                'periodicidad' => 'Semanal',
                'hora'=>'14:00',
                'dia' => '6',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '1',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Agencia Española de Medicamentos y Productos Sanitarios',
                'dominio' => 'www.aemps.gob.es',
                'periodicidad' => 'Semanal',
                'hora'=>'15:00',
                'dia' => '0',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '1',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Agencia Estatal de Meterología',
                'dominio' => 'www.aemet.es',
                'periodicidad' => 'Semanal',
                'hora'=>'15:00',
                'dia' => '1',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '1',
                'herramientas' => "$herramientas"
            ]
            ]);    
        

        #Entidades autonómicas y locales
        $json = array('accessmonitor' => false, 'achecker' => false, 'eiiichecker' => true, 
        'observatorio' => false, 'vamola' => true,'wave' => true);

        $herramientas= json_encode($json);

        DB::table('sitios')->insert([
            [
                'nombre' => 'Ayuntamiento de San Vicente del Raspeig',
                'dominio' => 'www.raspeig.es',
                'periodicidad' => 'Diario',
                'hora'=>'15:00',
                'dia' => '2',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '2',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Ayuntamiento de Valencia',
                'dominio' => 'www.valencia.es',
                'periodicidad' => 'Semanal',
                'hora'=>'15:00',
                'dia' => '3',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '2',
                'herramientas' => "$herramientas"
            ]
            ]);
     

        #Entidades públicas empresariales
        $json = array('accessmonitor' => true, 'achecker' => false, 'eiiichecker' => true, 
        'observatorio' => true, 'vamola' => false,'wave' => false);

        $herramientas= json_encode($json);

        DB::table('sitios')->insert([
            [
                'nombre' => 'Instituto para la Diversificación y Ahorro de la Energía (IDAE)',
                'dominio' => 'www.idae.es',
                'periodicidad' => 'Diario',
                'hora'=>'15:00',
                'dia' => '4',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '3',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Instituto Español de Comercio Exterior (ICEX)',
                'dominio' => 'www.icex.es',
                'periodicidad' => 'Semanal',
                'hora'=>'15:00',
                'dia' => '5',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '3',
                'herramientas' => "$herramientas"
            ]
            ]);
        

        #Centros universitarios públicos 

        $json = array('accessmonitor' => true, 'achecker' => false, 'eiiichecker' => false, 
        'observatorio' => false, 'vamola' => true,'wave' => true);

        $herramientas= json_encode($json);

        DB::table('sitios')->insert([
            [
                'nombre' => 'Universidad Miguel Hernández (UMH)',
                'dominio' => 'www.umh.es',
                'periodicidad' => 'Diario',
                'hora'=>'15:00',
                'dia' => '6',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '4',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Universitat de València (UV)',
                'dominio' => 'www.uv.es',
                'periodicidad' => 'Semanal',
                'hora'=>'16:00',
                'dia' => '0',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '4',
                'herramientas' => "$herramientas"
            ]
            ]);

        #Empresas privadas  

        $json = array('accessmonitor' => true, 'achecker' => false, 'eiiichecker' => true, 
        'observatorio' => true, 'vamola' => true,'wave' => false);

        $herramientas= json_encode($json);

        DB::table('sitios')->insert([
            [
                'nombre' => 'Banco Santander',
                'dominio' => 'www.bancosantander.es',
                'periodicidad' => 'Diario',
                'hora'=>'16:00',
                'dia' => '1',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '5',
                'herramientas' => "$herramientas"
            ],
            [
                'nombre' => 'Iberia',
                'dominio' => 'www.iberia.com',
                'periodicidad' => 'Semanal',
                'hora'=>'16:00',
                'dia' => '2',
                'automatizado' => false, 
                'num_paginas' => '10',
                'categoria_id' => '5',
                'herramientas' => "$herramientas"
            ]
            ]);
        
    }
}
