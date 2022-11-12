<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**Cuando creamos más de un metodo no usamos __invoke
 * En este caso queremos administrar 3 rutas distintas para cursos
 * 1.- Por convencion al metodo "Muestra" la pag principal se le llama "index"
 * 2.- Al metodo para "Crear" mediante formulario se le suele poner "create"
 * 3.- Al metodo para "Mostar" un solo "curso" se le suele llamar "show"
*/

class CursoController extends Controller
{
    public function index (){
/*Para entrar a una carpeta en php se usa . cursos.index es /cursos/index.php */
        return view('cursos.index');
    }
    public function create (){
        return view('cursos.create');
    }
    public function show ($curso){
/**-------------------------Cachar Variables--------------------------------------
 * 2 Formas de Rescatar una variable y pasarla a la vista:
 *1raforma  |    ruta    |nombreDeRescateDeVariableEnLaVista |asigno a |nombreVariableEnAPI
 *     view('ruta/vista', [     'curso'                          =>            $curso ])
 *2da Forma con compact('curso')cacho la $var de la API
        El nombre que ponga dentro de los () es como lo lee el front entre ''
----------------------------------------------------------------------------------- */
        return view('cursos.show', compact('curso'));
    }
}
