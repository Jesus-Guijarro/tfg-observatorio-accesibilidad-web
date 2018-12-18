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
Route::get('lista-sitios/{categoria?}', 'SitioController@listarSitios');
Route::get('busqueda-sitios/{categoria?}', 'SitioController@busquedaSitio');

#Pagina web
Route::get('pagina/{id}', 'PaginaController@mostrarPagina');

#Reporte
Route::get('reporte-automatico/{reporte}', 'PaginaController@mostrarReporteAutomatico');

#Usuarios
Route::get('perfil/{id}', 'UserController@mostrarPerfilUsuario');
Route::get('modificar-perfil/{id}', 'UserController@modificarPerfilUsuario');

#Administrador
Route::get('panel-admin/{id}', 'UserController@mostrarPanelAdministrador');

#Gestión sitios web
Route::get('gestionar-sitios/{nombre?}', 'SitioController@gestionarSitios');

Route::get('crear-sitio', 'SitioController@panelCrearSitio');
Route::post('crear-sitio', 'SitioController@crearSitio');

Route::get('modificar-sitio/{id}', 'SitioController@panelModificarSitio');
Route::post('modificar-sitio/{id}', 'SitioController@modificarSitio');

Route::get('eliminar-sitio/{id}', 'SitioController@eliminarSitio');

#Gestión paginas web
Route::get('gestionar-paginas/{sitio_id}', 'PaginaController@gestionarPaginas');
Route::post('gestionar-paginas/{sitio_id}', 'PaginaController@crearPagina');
Route::get('eliminar-pagina/{id}', 'PaginaController@eliminarPagina');

Route::get('modificar-pagina/{id}', 'PaginaController@panelModificarPagina');
Route::post('modificar-pagina/{id}', 'PaginaController@modificarPagina');

#Gestión herramientas
Route::get('gestionar-herramientas', 'HerramientaController@gestionarHerramientas');
Route::post('gestionar-herramientas', 'HerramientaController@modificarHerramienta');

Route::get('crear-herramienta', function()
{
    return View::make('pages.administrador.crear-herramienta');
});
Route::post('crear-herramienta', 'HerramientaController@crearHerramienta');

Route::get('desactivar-herramienta/{id}', 'HerramientaController@desactivarHerramienta');
Route::get('activar-herramienta/{id}', 'HerramientaController@activarHerramienta');


#Preguntas frecuentes
Route::get('faq', function()
{
    return View::make('pages.faq');
});

#Contacto
Route::get('contacto', function()
{
    return View::make('pages.contacto');
});

Route::get('w', function()
{
    return View::make('pages.welcome');
});

