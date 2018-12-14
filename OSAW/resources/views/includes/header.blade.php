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
                <a class = "a-hf" href="/perfil/{{Auth::user()->id}}" >
                    {{ Auth::user()->nombre}}, Perfil de usuario
                </a>
            </li>
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
    <form method="POST" action="{{ route('busqueda-sitios') }}">
            <label class="label-buscador" for="nombre" >Buscar Sitio Web: </label>
            <input type="text" placeholder="Buscar sitio web..." id ="nombre" name="nombre" value="Ministerio" required autofocus>
            {{ csrf_field() }}
    </form>
</div>