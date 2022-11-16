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
    $cursos = Curso::orderBy('id', 'desc')->paginate();
        
    //compact() sirve para cachar variables, en este caso se cacha en la vista como "cursos" la var "$cursos" del Controller
        return view('cursos.index',compact('cursos'));
    }
    public function create (){
        return view('cursos.create');
    }
    public function store(Request $request){
        //testeo el $request así: return $request->all(); / incluye toda la data enviada y el token de @csrf
        //validacion
        $request->validate([
            'name'        => 'required',
            'description' => 'required',
            'category' => 'required'
        ]);
        $curso = new Curso();//instancío
        // //mapeo-asignacion manual
        // $curso->name = $request->name;
        // $curso->description = $request->description;
        // $curso->category = $request->category;
    
        //asignacion masiva
        $curso = Curso::create($request->all());

        //return $curso; //testeo que me devuelva la data mapeada 
        $curso->save();//guardo
        //pedir una redireccion al index o al registro que queremos
        return redirect()->route('cursos.show',$curso);
    }

    public function show (Curso $curso){//antes por parametros era $id
/**-------------------------Cachar Variables--------------------------------------
 * 2 Formas de Rescatar una variable y pasarla a la vista:
 *1raforma  |    ruta    |nombreDeRescateDeVariableEnLaVista |asigno a |nombreVariableEnAPI
 *     view('ruta/vista', [     'curso'                          =>            $curso ])
 *2da Forma con compact('curso')cacho la $var de la API
        El nombre que ponga dentro de los () es como lo lee el front entre ''
------------------------Instanciando variables/data------------------------------------------- 
        *  Recibo $curso como esta en web.php  que estoy trayendo desde el front al llamar el metodo show,desde index.php
        *  puedo crear la variable $curso que ahora va a escuchar el front al hacer compact('curso'), como respuesta en la vista show y de valor se asigna la data que traigo de la DB con find($id) 
        $curso = Curso::find($id);
        AUNQUE Una mejor forma de hacer ésto es con instancia desde parametros, LO QUE RECIBO POR API. lO INSTANCIO EN PARAMETROS COMO UN OBJETO TIPO EL MODELO
----------------------------------------------------------------------------------------------- 
 **/        //testeo dd($curso);
        return view('cursos.show', compact('curso'));
    }

    public function edit(Curso $curso)//por la url se esta mandando $id el cual se cambio a $curso por buenas practicas y se pasa como param a manera de objeto del modelo Curso, para que directamente entrando se ubique como modelo y busque su id
    {
        // return $registro = Curso::find($curso); // Usar esta linea es igual a poner en parametros Curso $curso- es instanciar desde parametros

     return view('cursos.edit', compact('curso'));   
    }

    public function update(Request $request, Curso $curso)
    {
        //testeo //return $curso;// deberia devoler el objeto al dar click en actualizar
        //validacion
        $request->validate([
            'name'        => 'required|max:10',
            'description' => 'required|min:10',
            'category' => 'required'
        ]);
        $curso->name = $request->name;
        $curso->description = $request->description;
        $curso->category = $request->category;
        $curso->save();
        return redirect()->route('cursos.show',$curso);
    }

    public function destroy(Curso $curso){
        $curso->delete();
        return redirect()->route('cursos.index');
        
    }
}