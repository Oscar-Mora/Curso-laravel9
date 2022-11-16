@extends('layouts.plantilla')

@section('title', 'Show') 



@section('content')   

{{-- <h1>"Bienvenido a la página del curso de: < ?= $curso;?>"</h1>
AHORA CAMBIAMOS LA SINTAXIS PARA QUE SE VEA MEJOR  --}}
<div>
    <h1>"Bienvenido a la página del curso de: {{$curso->name}}<h1>
    <div class="btns-group">
        <a href="{{route('cursos.index')}}" class="volver">Volver a Cursos</a>
        <br>
        <a href="{{route('cursos.edit',$curso)}}" class="editar"> Editar curso</a>
    </div>
    <span>Categoría:{{$curso->category}}</span>
    <p>{{$curso->description}}</p>

    <form action="{{route('cursos.destroy', $curso)}}" method="POST">
        @csrf
        @method('delete')
        <button type="submit" >
            Eliminar
        </button>
    </form>
</div>


@endsection
