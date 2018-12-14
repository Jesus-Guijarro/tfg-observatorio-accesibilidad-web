<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
Route::get('/', function () {
    return view('pages.welcome');
});
*/
Auth::routes();

Route::get('/', function()
{
    return View::make('pages.inicio');
});

#Sitios web
Route::get('sitio/{id}', 'SitioController@mostrarSitio');

Route::get('lista-sitios', 'SitioController@listarSitios');

Route::get('busqueda-sitios', 'SitioController@busquedaSitio')->name('busqueda-sitios');



#Pagina web
Route::get('pagina/{id}', 'PaginaController@mostrarPagina');
Route::get('reporte-automatico/{id}', 'PaginaController@mostrarReporteAutomatico');

#Usuarios
Route::get('perfil/{id}', 'UserController@mostrarPerfilUsuario');
Route::post('modificar-perfil/{id}', 'UserController@modificarPerfilUsuario');

#Gestión sitios web
Route::get('gestionar-sitios', 'SitioController@gestionarSitios');
Route::post('crear-sitio', 'SitioController@crearSitio');
Route::post('modificar-sitio/{id}', 'SitioController@modificarSitio');


#Sobre el observatorio
Route::get('sobre-observatorio', function()
{
    return View::make('pages.sobre-observatorio');
});

#Contacto
Route::get('contacto', function()
{
    return View::make('pages.contacto');
});

Route::get('ejemplo', function() {
    $url = url('foo');
    return $url ;
    });