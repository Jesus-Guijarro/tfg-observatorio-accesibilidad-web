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
        
        #Sitios con todas las herramientas asignadas
        DB::table('sitios')->insert([
            [
                'nombre' => 'Ministerio de Justicia',
                'dominio' => 'www.mjusticia.gob.es',
                'periodicidad' => 'Semanal',
                'hora'=>'13:00',
                'dia' => '0',
                'automatizado' => false, 
                'categoria_id' => '1'
                
            ],
            [
                'nombre' => 'Agencia Estatal de Administración Tributaria',
                'dominio' => 'www.agenciatributaria.es',
                'periodicidad' => 'Semanal',
                'hora'=>'13:00',
                'dia' => '1',
                'automatizado' => false, 
                'categoria_id' => '1'
                
            ],
            [
                'nombre' => 'Generalitat Valenciana',
                'dominio' => 'www.gva.es',
                'periodicidad' => 'Semanal',
                'hora'=>'13:00',
                'dia' => '2',
                'automatizado' => false, 
                'categoria_id' => '2'
                
            ],
            [
                'nombre' => 'Ayuntamiento de Alicante',
                'dominio' => 'www.alicante.es',
                'periodicidad' => 'Semanal',
                'hora'=>'13:00',
                'dia' => '3',
                'automatizado' => false, 
                'categoria_id' => '2'
                
            ],
            [
                'nombre' => 'Red Nacional de los Ferrocarriles Españoles (RENFE)',
                'dominio' => 'www.renfe.com',
                'periodicidad' => 'Semanal',
                'hora'=>'13:00',
                'dia' => '4',
                'automatizado' => false, 
                'categoria_id' => '3'
                
            ],
            [
                'nombre' => 'Centro para el Desarrollo Tecnológico Industrial (CDTI)',
                'dominio' => 'www.cdti.es',
                'periodicidad' => 'Semanal',
                'hora'=>'13:00',
                'dia' => '5',
                'automatizado' => false, 
                'categoria_id' => '3'
                
            ],
            [
                'nombre' => 'Universitat Politècnica de València (UPV)',
                'dominio' => 'www.upv.es',
                'periodicidad' => 'Semanal',
                'hora'=>'13:00',
                'dia' => '6',
                'automatizado' => false, 
                'categoria_id' => '4'
                
            ],
            [
                'nombre' => 'Universidad de Alicante (UA)',
                'dominio' => 'web.ua.es',
                'periodicidad' => 'Semanal',
                'hora'=>'13:30',
                'dia' => '0',
                'automatizado' => false, 
                'categoria_id' => '4'
                
            ],
            [
                'nombre' => 'Endesa',
                'dominio' => 'www.endesaclientes.com',
                'periodicidad' => 'Semanal',
                'hora'=>'13:30',
                'dia' => '1',
                'automatizado' => false, 
                'categoria_id' => '5'
                
            ],
            [
                'nombre' => 'Iberdrola',
                'dominio' => 'www.iberdrola.es',
                'periodicidad' => 'Semanal',
                'hora'=>'13:30',
                'dia' => '2',
                'automatizado' => false, 
                'categoria_id' => '5'
                
            ]
            ]);
        
        #Ministerios y agencias estatales
        DB::table('sitios')->insert([
            [
                'nombre' => 'Ministerio de Sanidad, Consumo y Bienestar Social',
                'dominio' => 'www.mscbs.gob.es',
                'periodicidad' => 'Semanal',
                'hora'=>'13:30',
                'dia' => '3',
                'automatizado' => false, 
                'categoria_id' => '1'
                
            ],
            [
                'nombre' => 'Ministerio de Ciencia, Innovación y Universidades',
                'dominio' => 'www.ciencia.gob.es',
                'periodicidad' => 'Semanal',
                'hora'=>'13:30',
                'dia' => '4',
                'automatizado' => false, 
                'categoria_id' => '1'
                
            ],
            [
                'nombre' => 'Ministerio de Cultura y Deporte',
                'dominio' => 'www.culturaydeporte.gob.es',
                'periodicidad' => 'Semanal',
                'hora'=>'13:30',
                'dia' => '5',
                'automatizado' => false, 
                'categoria_id' => '1'
                
            ],
            [
                'nombre' => 'Ministerio de Trabajo, Migraciones y Seguridad Social',
                'dominio' => 'www.mitramiss.gob.es',
                'periodicidad' => 'Semanal',
                'hora'=>'13:30',
                'dia' => '6',
                'automatizado' => false, 
                'categoria_id' => '1'
                
            ],
            [
                'nombre' => 'Agencia Española de Medicamentos y Productos Sanitarios',
                'dominio' => 'www.aemps.gob.es',
                'periodicidad' => 'Semanal',
                'hora'=>'14:00',
                'dia' => '0',
                'automatizado' => false, 
                'categoria_id' => '1'
                
            ],
            [
                'nombre' => 'Agencia Estatal de Meteorología',
                'dominio' => 'www.aemet.es',
                'periodicidad' => 'Semanal',
                'hora'=>'14:00',
                'dia' => '1',
                'automatizado' => false, 
                'categoria_id' => '1'
                
            ]
            ]);    
        

        #Entidades autonómicas y locales

        DB::table('sitios')->insert([
            [
                'nombre' => 'Ayuntamiento de San Vicente del Raspeig',
                'dominio' => 'www.raspeig.es',
                'periodicidad' => 'Semanal',
                'hora'=>'14:00',
                'dia' => '2',
                'automatizado' => false, 
                'categoria_id' => '2'
                
            ],
            [
                'nombre' => 'Ayuntamiento de Valencia',
                'dominio' => 'www.valencia.es',
                'periodicidad' => 'Semanal',
                'hora'=>'14:00',
                'dia' => '3',
                'automatizado' => false, 
                'categoria_id' => '2'
                
            ]
            ]);
     

        #Entidades públicas empresariales

        DB::table('sitios')->insert([
            [
                'nombre' => 'Instituto para la Diversificación y Ahorro de la Energía (IDAE)',
                'dominio' => 'www.idae.es',
                'periodicidad' => 'Semanal',
                'hora'=>'14:00',
                'dia' => '4',
                'automatizado' => false, 
                'categoria_id' => '3'
                
            ],
            [
                'nombre' => 'Instituto Español de Comercio Exterior (ICEX)',
                'dominio' => 'www.icex.es',
                'periodicidad' => 'Semanal',
                'hora'=>'14:00',
                'dia' => '5',
                'automatizado' => false, 
                'categoria_id' => '3'
                
            ]
            ]);
        

        #Centros universitarios públicos 

        DB::table('sitios')->insert([
            [
                'nombre' => 'Universidad Miguel Hernández (UMH)',
                'dominio' => 'www.umh.es',
                'periodicidad' => 'Semanal',
                'hora'=>'14:00',
                'dia' => '6',
                'automatizado' => false, 
                'categoria_id' => '4'
                
            ],
            [
                'nombre' => 'Universitat de València (UV)',
                'dominio' => 'www.uv.es',
                'periodicidad' => 'Semanal',
                'hora'=>'14:30',
                'dia' => '0',
                'automatizado' => false, 
                'categoria_id' => '4'
                
            ]
            ]);

        #Empresas privadas  

        DB::table('sitios')->insert([
            [
                'nombre' => 'Banco Santander',
                'dominio' => 'www.bancosantander.es',
                'periodicidad' => 'Semanal',
                'hora'=>'14:30',
                'dia' => '1',
                'automatizado' => false, 
                'categoria_id' => '5'
                
            ],
            [
                'nombre' => 'Iberia',
                'dominio' => 'www.iberia.com',
                'periodicidad' => 'Semanal',
                'hora'=>'14:30',
                'dia' => '2',
                'automatizado' => false, 
                'categoria_id' => '5'   
            ],
            [
                'nombre' => 'Movistar',
                'dominio' => 'www.movistar.es',
                'periodicidad' => 'Semanal',
                'hora'=>'14:30',
                'dia' => '3',
                'automatizado' => false, 
                'categoria_id' => '5'
            ]
            ]);
        
    }
}
