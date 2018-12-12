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

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/', function()
{
    return View::make('pages.home');
});

#Sitios web
Route::get('sitio/{id}', 'SitioController@mostrarSitio');

Route::get('lista-sitios', function()
{
    return View::make('pages.lista-sitios');
});

Route::get('busqueda-sitios/{nombre}', 'SitioController@busquedaSitio');


#Pagina web
Route::get('pagina/{id}', 'PaginaController@mostrarPagina');
Route::get('pagina/{id}/reporte-automatico', 'PaginaController@mostrarReporteAutomatico');

#Usuarios
Route::get('usuario/{id}', 'UserController@mostrarPerfilUsuario');
Route::post('usuario/{id}/modificar-perfil', 'UserController@modificarPerfilUsuario');

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
Route::post('contacto', function()
{
    return View::make('pages.contacto');
});

