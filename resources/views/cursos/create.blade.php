
@extends('layouts.plantilla')

@section('title', 'Create') 

@section('content')   

<h1>"En esta página  podrás crear un curso"</h1>
{{-- {{route('cursos.store')}} --}}

<form action="{{route('cursos.store')}}" method = "POST">
    @csrf 
    {{-- @csrf Agrega un input oculto con un nombre llamado token y se encarga de generar un token --}}
    <label for="name">
        Nombre
        <br>
        <input type="text" name='name' value="{{old('name')}}">
    </label>
    @error('name')
    <br>
    <small>{{$message}}</small>
    <br>
    @enderror
    <br>
    <label for="description">
        Descripcion
        <br>
        <textarea name="description"  rows="5" value="{{old('description')}}"></textarea>
    </label>
    @error('description')
    <br>
    <small>{{$message}}</small>
    <br>
    @enderror
    <br>
    <label for="category">
        Categoría
        <br>
        <input type="text" name='category' value="{{old('description')}}">
    </label>
    @error('category')
    <br>
    <small>{{$message}}</small>
    <br>
    @enderror
    <br>
    <button type="submit">Guardar</button>

</form>

@endsection
