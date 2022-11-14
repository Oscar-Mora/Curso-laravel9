<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

/**Cuando creamos más de un metodo no usamos __invoke
 * En este caso queremos administrar 3 rutas distintas para cursos
 * 1.- Por convencion al metodo "Muestra" la pag principal se le llama "index"
 * 2.- Al metodo para "Crear" mediante formulario se le suele poner "create"
 * 3.- Al metodo para "Mostar" un solo "curso" se le suele llamar "show"
*/

/*Para entrar a una carpeta en php se usa . cursos.index es /cursos/index.php */
class CursoController extends Controller
{
    public function index (){
    //creo una variable para generar la data y poderla mandar al front
    $cursos = Curso::paginate();
        
    //compact() sirve para cachar variables, en este caso se cacha en la vista como "cursos" la var "$cursos" del Controller
        return view('cursos.index',compact('cursos'));
    }
    public function create (){
        return view('cursos.create');
    }
    public function show ($id){
/**-------------------------Cachar Variables--------------------------------------
 * 2 Formas de Rescatar una variable y pasarla a la vista:
 *1raforma  |    ruta    |nombreDeRescateDeVariableEnLaVista |asigno a |nombreVariableEnAPI
 *     view('ruta/vista', [     'curso'                          =>            $curso ])
 *2da Forma con compact('curso')cacho la $var de la API
        El nombre que ponga dentro de los () es como lo lee el front entre ''
----------------------------------------------------------------------------------- */
//Creo la variable que va a escuchar el front, y el valor de ésta variable es la $id var que estoy trayendo desde el front al llamar el metodo show y con find() le estoy buscando su data en la bd del modelo Cursos
        $curso = Curso::find($id);
        //testeo dd($curso);
        return view('cursos.show', compact('curso'));
    }
}