 <!-- header     -->
 <header>
    <h1>My Courses CRUD</h1>
    <!-- nav -->
    <nav>
        <li>
            <a href="{{route('Home')}}" class="{{request()->routeIs('Home') ? 'active':''}}">Home</a>
                {{-- @dump(request()->routeIs('Home'))NOS PERMITE VER SI ESTÁ ACTIVA O NO LA VISTA--}}
        </li>
        <li>
            <a href="{{route('cursos.index')}}" class="{{request()->routeIs('cursos.*')?'active':''}}">Cursos</a>
            {{-- @dump(request()->routeIs('cursos.*')) --}}
        </li>
        <li>
            <a href="{{route('nosotros')}}" class="{{request()->routeIs('nosotros')?'active':''}}">Nosotros</a>
            {{-- @dump(request()->routeIs('nosotros')) --}}
        </li>
        
    </nav>
    </header>