<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- favicon -->
    <!-- estilos -->
<style>
    h1{
        color: darkslategrey;
    }
    a{
        color:darkcyan;
        text-decoration: none;
    }
    nav
    {
        display: flex;
        flex-direction: row;
        padding: 10px;
        margin: 10px;
    }
    nav>li
    {

        margin: 10px;
    }
    li
    {
        list-style: none;            
    }
    .listado{
        font-size: 25px;
    }
    .active{
        color: rgb(88, 69, 233);
    }
    .volver{
        font-size: 20px;
        color: aliceblue;
        border: solid rgb(20, 180, 220);
        border-radius: 10px;
        background-color: darkslategray;
        padding: 4px;
    }
    .crear{
        font-size: 20px;
        color: aliceblue;
        border: solid rgb(20, 180, 220);
        border-radius: 10px;
        background-color: darkslategray;
        margin: 30px;
        padding: 4px;
    }
    .editar{
        font-size: 20px;
        color: aliceblue;
        border: solid rgb(20, 180, 220);
        border-radius: 10px;
        background-color: darkslategray;
        padding: 4px;
    }
    .btns-group{
        display: flex;
        margin: 10px;
        align-items: flex-end;
    }
    .btns-group>a{
        margin: 5px;
        
    }
</style>
 
</head>
<body>
   @include('layouts.partials.header')
    @yield('content')
    <!-- footer -->
    <!-- script -->
</body>
</html>