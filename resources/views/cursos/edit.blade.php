
@extends('layouts.plantilla')

@section('title', 'Create') 

@section('content')   

<h1>"En esta página  podrás editar un curso"</h1>
{{-- {{route('cursos.store')}} --}}

<form action="{{route('cursos.update', $curso)}}" method = "POST">
    @csrf 
    @method('put')
    {{-- @csrf Agrega un input oculto con un nombre llamado token y se encarga de generar un token --}}
    <label for="name">
        Nombre
        <br>
        <input type="text" name='name' value ="{{$curso->name}}" >
    </label>
    <br>
    <label for="description">
        Descripcion
        <br>
        <textarea name="description"  rows="5" 
        >{{$curso->description}}</textarea>
    </label>
    <br>
    <label for="category">
        Categoría
        <br>
        <input type="text" name='category' value ="{{$curso->category}}">
    </label>
    <br>
    <button type="submit">Actualizar</button>

</form>

@endsection
