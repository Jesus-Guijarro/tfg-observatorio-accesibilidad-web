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

Route::get('/', 'HomeController@mostrarInicio');

#Sitios web
Route::get('sitio/{id}', 'SitioController@mostrarSitio');
Route::get('lista-sitios', 'SitioController@listarSitios');
Route::get('busqueda-sitios', 'SitioController@busquedaSitio');

#Pagina web
Route::get('pagina/{id}', 'PaginaController@mostrarPagina');

#Reporte
Route::get('reporte-automatico/{reporte}', 'PaginaController@mostrarReporteAutomatico');

#Usuarios
Route::get('perfil/{id}', 'UserController@mostrarPerfilUsuario');
Route::post('modificar-perfil/{id}', 'UserController@modificarPerfilUsuario');

#Gestión sitios web
Route::get('gestionar-sitios', 'SitioController@gestionarSitios');
Route::post('crear-sitio', 'SitioController@crearSitio');
Route::post('modificar-sitio/{id}', 'SitioController@modificarSitio');

#Sobre el observatorio
Route::get('faq', function()
{
    return View::make('pages.faq');
});

#Contacto
Route::get('contacto', function()
{
    return View::make('pages.contacto');
});

Route::get('test', function()
{
    return View::make('test');
});
