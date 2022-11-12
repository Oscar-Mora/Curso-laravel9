<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
/**como asignar un controlador a una ruta:
 * 1.-ponemos use App\Http\Controllers/HomeController; dentro de web.php
 * 2.-Asignamos la clase en la Route que se va a usar, despues de la ruta, llamando HomeController::class
 *  Route::get('/',HomeController::class );
 * 3.-Dentro de la clase, creamos un metodo en una public function(), 
 * en el ejemplo será metodo __invoke()*/

class HomeController extends Controller
{
/**Cuando utilizamos un metodo __invoke(), es cuando queremos que solo administre una sola ruta */
    public function __invoke(){
        
        return view('home');
    }
}
