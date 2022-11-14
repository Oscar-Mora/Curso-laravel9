@extends('layouts.plantilla')

@section('title', 'Cursos') 

@section('content')   

<h1>'Bienvenido a la página de cursos'</h1>
<a href="{{route('cursos.create')}}">Crear Curso</a>
    <ul>
        @foreach ($cursos as $curso)
        
<!--Para poder ver el VALUE de la variable $curso de $cursos se usa la INTERPOLACION {}x2 Además hay que acceder a cada propiedad con "->" y nombre de la propiedad..por cada campo que quiera llevar a la vista con el usuario, por ejemplo mostrar solo el nombre:"$curso->name"-->
            <li>
        <!--Para pasar parametros a una route() que pide argumentos, se asigna como 2do argumento en los parentesis como a continuación,
        que dice que del item($curso->id) encuentre el id y en la  lo devuelva-->
                <a href="{{route('cursos.show',$curso->id)}}">{{$curso->name}}</a>
            </li>
        @endforeach
    </ul>
    {{$cursos->links()}}
@endsection
