<?php

use App\Http\Controllers\HomeController; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;
/*
--------------------------------------------------------------------------
  ** I M P O R T A N T E**
 Laravel lee las RUTAS de Inicio  a Fin, si yo pusiera la ruta ->  Route::get('cursos/{curso}','show');
 antes que la ruta --> Route::get('cursos/create','create');
 Aunque yo sé que es un metodo para crear un nuevo curso, 
 laravel mandaría la palabra create como variable y entraría como si fuera un curso más

*/
/** | Usar unica ruta o Array dentro de Route::__VerboHttp__('/ruta',..)?
 *  | Sí dejamos como en la linea siguiente,-->" Route::get('cursos',CursoController::class); "<--- la ruta a Cursos, buscará el metodo __invoke()
 *  | ENTONCES, SE DECLARA la Clase como un array.  
 *  | El array contiene, la "Class" y el "Método" dentro de la "Class" que se está llamando ver:  Route::get('cursos',[CursoController::class,'index']);  se hace lo mismo para cada metodo que necesitemos del controller
 * */
Route::get('/',HomeController::class);
 
/**  Generar un grupo de rutas.?
 *   |1.- se hace el use App\Http\Controllers\CursoController;
 *   |2.- Se define la "Route", 
 *   |se define el controlador en común ::controller(CursoController:.class), 
 *   |se define que sea un grupo en una f anonima ->group(function()){ RUTAS }
 *   |3.- Las rutas tienen estructura de Route::_verboHttp_('/ruta','metodo')
* */
Route::controller(CursoController::class)->group(function(){
  /**-----------------Asignacion de NOMBRE DE RUTA-------------------------------------------------*
   * Ayuda a hacer referencia desde las vistas  a las RUTAS con ("->name('nombreAsignado')")en el archivo de rutas y con {{route('route.nameAssigned')}} en el archivo de la vista
   * Laravel recomienda que se de un nombre indetificativo a cada una de las rutas, permite seguir dirigiendo a la misma ruta establecida aunque la nomenclatura de la ruta cambie
   * Ejemplo si 'cursos/create' cambia a 'courses/create' y su nombre de ruta identificativa es 'cursos.create', así
   * Aunque cambie el nombre de la RUTA  el nombre de la ruta-asignada seguira identificando a donde ir y que hacer.
   * --------------------------------------------------------------------------------------------
*/
    Route::get('cursos','index')->name('cursos.index');
    Route::get('cursos/create','create')->name('cursos.create');
    Route::get('cursos/{curso}','show')->name('cursos.show');
    Route::get('cursos/{curso}/edit','edit')->name('cursos.edit');
});

//Rutas para modificar lo que hay en BD

Route::post('cursos/',[CursoController::class,'store'])->name('cursos.store');
Route::put('cursos/{curso}',[CursoController::class,'update'])->name('cursos.update');







/**| COMO INTRODUCCION SE ESCRIBIERON SEPARADAS LAS RUTAS, 
 * | para ejemplificar los tipos de rutas y las vista que devuelven 
 * | Ahora se usará una  clase del Controlador, y despues se formará un grupo de rutas
 * | así que copiamos los return momentaneos para llevarlos al controller y continuar el curso 
 * | Route::get('/',HomeController::class);
 * |//     Route::get('/',function () {
 * |    // return view('welcome');
 * |    // return 'Bienvenido a la página de inicio';
 * |// });
 * |Route::get('cursos', function () {
 * |    
 * |    return 'Bienvenido a la página de cursos';
 * |});
 * | 
 * | //para crear, (como no le estoy pasando nungún dato no lleva variable, por convencion.. 
 * |Route::get('cursos/create', function () {
 * |    return "En esta página  podrás crear un curso";
 * |    
 * |});
 * | 
 * |// tambien le podemos pasar una $variable por la api y devolver entre " "
 * |Route::get('cursos/{curso}', function ($curso) {
 * |    return "Bienvenido a la página del curso de: $curso";
 * |});*/
    
/**| TAMBIEN PODEMOS PASAR MÁS DE UN PARAMETRO EN LA URL
 * |Podríamos cancelar la ruta 'cursos/{curso}' que lleva solo una $variable y unificar en la siguiente ruta diciendo que sea opcional si entran a la 2da $variable "categoría" con ? en la ruta y 
 * |validando en el return cual fue la decisión que tomó el usuario:
 * |   Route::get('cursos/{curso}/{categoria?}', function ($curso, $categoria = null) {
 * |   if($categoria){
 * |       return "Bienvenido al $curso de la categoría $categoria";
 * |   }
 * |   else{
 * |       return "Bienvenido al curso: $curso.";
 * |   }
 * |   });
 * | SIN EMBARGO. ésta lógica aplicada en el ejemplo arriba, será mejor ponerla en un controlador y derivar esa tarea al Controller-controlador */