<nav class="nav-cabecera">
    <a class = "a-hf" href="{{ url('/') }}">
        <div class="osaw">
            <p class="p-osaw">OSAW</p> 
        </div>
        <div>
            <p>Observatorio para el Seguimiento de la Accesibilidad Web</p> 
        </div>
    </a>

    <!-- Right Side Of Navbar -->
    <ul class="ul-cabecera">
        <!-- Authentication Links -->
        @guest
            <li class="li-cabecera">
                <a class = "a-hf" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
            </li>
            <li class="li-cabecera">
                @if (Route::has('register'))
                    <a class = "a-hf" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                @endif
            </li>
        @else
            <li class="li-cabecera">
                
                <a class = "a-hf" href="/perfil/{{Auth::user()->id}}"> <img class="avatar-header" src="/storage/{{Auth::user()->avatar}}" alt="avatar usuario"></a>
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




<div class="buscador">
    <form method="GET" action="{{ action('SitioController@busquedaSitio') }}">
        <label class="label-buscador" for="nombre" >Buscar Sitio Web: </label>
        <input type="text" id ="nombre" name="nombre" required autofocus>
        {{ csrf_field() }}
    </form>
</div>