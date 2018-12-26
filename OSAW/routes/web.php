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

Auth::routes();

/*Inicio*/
Route::get('/', 'HomeController@mostrarInicio');

#Sitios web
Route::get('sitio/{id}', 'SitioController@mostrarSitio');
Route::get('lista-sitios/{categoria?}', 'SitioController@listarSitios');
Route::post('lista-sitios/{categoria?}', 'SitioController@listarSitiosPorCategoria');
Route::get('busqueda-sitios/{categoria?}', 'SitioController@busquedaSitio');
Route::post('busqueda-sitios/{categoria?}', 'SitioController@busquedaSitioPorCategoria');

#Pagina web
Route::get('pagina/{id}', 'PaginaController@mostrarPagina');

#Reporte
Route::get('reporte-automatico/{reporte}', 'PaginaController@mostrarReporteAutomatico');

#Usuarios
Route::get('perfil/{id}', 'UserController@mostrarPerfilUsuario')->middleware('auth','prevenirAtras','prevenirAtras');

Route::get('modificar-perfil/{id}', 'UserController@panelModificarPerfilUsuario')->middleware('auth','prevenirAtras');
Route::post('modificar-perfil/{id}', 'UserController@modificarPerfilUsuario')->middleware('auth','prevenirAtras');

Route::get('cambiar-password/{id}', 'UserController@panelCambiarPassword')->middleware('auth','prevenirAtras');
Route::post('cambiar-password/{id}', 'UserController@cambiarPassword')->middleware('auth','prevenirAtras');

Route::get('participantes', 'UserController@listarUsuarios');

#Gestión sitios web
Route::get('gestionar-sitios/{nombre?}', 'SitioController@gestionarSitios')->middleware('auth','prevenirAtras','esAdmin');

Route::get('crear-sitio', 'SitioController@panelCrearSitio')->middleware('auth','prevenirAtras','esAdmin');
Route::post('crear-sitio', 'SitioController@crearSitio')->middleware('auth','prevenirAtras','esAdmin');

Route::get('modificar-sitio/{id}', 'SitioController@panelModificarSitio')->middleware('auth','prevenirAtras','esAdmin');
Route::post('modificar-sitio/{id}', 'SitioController@modificarSitio')->middleware('auth','prevenirAtras','esAdmin');

Route::get('eliminar-sitio/{id}', 'SitioController@eliminarSitio')->middleware('auth','prevenirAtras','esAdmin');

#Gestión paginas web
Route::get('gestionar-paginas/{sitio_id}', 'PaginaController@gestionarPaginas')->middleware('auth','prevenirAtras','esAdmin');
Route::post('gestionar-paginas/{sitio_id}', 'PaginaController@crearPagina')->middleware('auth','prevenirAtras','esAdmin');

Route::get('modificar-pagina/{id}', 'PaginaController@panelModificarPagina')->middleware('auth','prevenirAtras','esAdmin');
Route::post('modificar-pagina/{id}', 'PaginaController@modificarPagina')->middleware('auth','prevenirAtras','esAdmin');

Route::get('eliminar-pagina/{id}', 'PaginaController@eliminarPagina')->middleware('auth','prevenirAtras','esAdmin');

#Gestión herramientas
Route::get('gestionar-herramientas', 'HerramientaController@gestionarHerramientas')->middleware('auth','prevenirAtras','esAdmin');
Route::post('gestionar-herramientas', 'HerramientaController@modificarHerramienta')->middleware('auth','prevenirAtras','esAdmin');

Route::get('crear-herramienta', function()
{
    return View::make('pages.administrador.crear-herramienta');
})->middleware('auth','prevenirAtras','esAdmin');
Route::post('crear-herramienta', 'HerramientaController@crearHerramienta')->middleware('auth','prevenirAtras','esAdmin');

Route::get('desactivar-herramienta/{id}', 'HerramientaController@desactivarHerramienta')->middleware('auth','prevenirAtras','esAdmin');
Route::get('activar-herramienta/{id}', 'HerramientaController@activarHerramienta')->middleware('auth','prevenirAtras','esAdmin');

Route::get('modificar-herramienta/{id}', 'HerramientaController@panelModificarHerramienta')->middleware('auth','prevenirAtras','esAdmin');
Route::post('modificar-herramienta/{id}', 'HerramientaController@modificarHerramienta')->middleware('auth','prevenirAtras','esAdmin');

#Gestión de usuarios
Route::get('gestionar-usuarios', 'UserController@gestionarUsuarios')->middleware('auth','prevenirAtras','esAdmin');
Route::get('hacer-experto/{id}', 'UserController@hacerExperto')->middleware('auth','prevenirAtras','esAdmin');
Route::get('hacer-colaborador/{id}', 'UserController@hacerColaborador')->middleware('auth','prevenirAtras','esAdmin');

#Logs
Route::get('logs', 'LogsController@mostrarLogs')->middleware('auth','prevenirAtras','esAdmin');
Route::get('log/{log}', 'LogsController@mostrarLog')->middleware('auth','prevenirAtras','esAdmin');

#Contacto
Route::get('contacto', function()
{
    return View::make('pages.contacto');
});
Route::post('contacto','ContactoController@realizarContacto');


