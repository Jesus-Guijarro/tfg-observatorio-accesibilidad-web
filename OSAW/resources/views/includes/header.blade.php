<nav class="nav-cabecera">
    <a class = "a-logo" href="{{ url('/') }}">
        <div class="osaw">
            <p class="p-osaw">OSAW</p> 
        </div>
        <div>
            <p style="margin-left: 1em;margin-right: 1em">Observatorio para el Seguimiento de la Accesibilidad Web</p> 
        </div>
    </a>

    <ul class="ul-cabecera" >
        @guest
            <li class="li-cabecera">
                <a class = "a-hf" href="{{ route('login') }}">Iniciar Sesión</a>
            </li>
            <li class="li-cabecera">
                @if (Route::has('register'))
                    <a class = "a-hf" href="{{ route('register') }}">Registrarse</a>
                @endif
            </li>
        @else
            <li class="li-cabecera">
                <a class = "a-hf" href="/perfil/{{Auth::user()->id}}"> <img class="avatar-header" src="/storage/{{Auth::user()->avatar}}" alt="avatar usuario {{ Auth::user()->nombre}}"></a>
            </li>
            <li class="li-cabecera">
                
                <a class = "a-hf" href="/perfil/{{Auth::user()->id}}"> {{ Auth::user()->nombre}}</a>
            </li>
            <!-- Opciones de administración -->
            @if (Auth::user()->rol_id===3)
            <li class="li-cabecera">
                <a class="dropdown-toggle" href="opciones-administracion" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="color:white">
                    Opciones de Administracion <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="/gestionar-sitios">
                        Gestionar Sitios Web
                    </a>
                    <a class="dropdown-item" href="/gestionar-herramientas">
                        Gestionar Herramientas de Evaluación
                    </a>
                    <a class="dropdown-item" href="/gestionar-usuarios">
                        Gestionar Usuarios
                    </a>
                    <a class="dropdown-item" href="/logs">
                        Ver archivos de registro de las evaluaciones
                    </a>
                </div>
            </li>
            @endif

            <li class="li-cabecera">
                <a class = "a-hf" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    {{ __('Cerrar sesión') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        @endguest
    </ul>
</nav>



<nav class="nav-cabecera-debajo">
    <ul class="ul-cabecera">
        <li class="li-cabecera" >
            <a class = "a-hf" href="/">Inicio </a>
        </li>
        <li class="li-cabecera" >
            <a class = "a-hf" href="/lista-sitios">Listado de sitios web </a>
        </li>
        <li class="li-cabecera" >
            <a class = "a-hf" href="/participantes">Participantes </a>
        </li>
        <li class="li-cabecera">
            <form class="form-buscador" method="GET" action="{{ action('SitioController@busquedaSitio') }}">
                <label class="label-buscador" for="nombre" >Buscar Sitio Web: </label>
                <input type="text" id ="nombre" name="nombre" required autofocus>
                {{ csrf_field() }}
            </form>
        </li>
    </ul>
</nav>