@extends('layouts.plantilla')

@section('title', 'Show') 

@section('content')   

{{-- <h1>"Bienvenido a la página del curso de: <?= $curso;?>"</h1>
AHORA CAMBIAMOS LA SINTAXIS PARA QUE SE VEA MEJOR  --}}
    <h1>"Bienvenido a la página del curso de: {{$curso->name}}<h1>
    <a href="{{route('cursos.index')}}">Volver a Cursos</a>
    <span>Categoría:{{$curso->category}}</span>
    <p>{{$curso->description}}</p>


@endsection
