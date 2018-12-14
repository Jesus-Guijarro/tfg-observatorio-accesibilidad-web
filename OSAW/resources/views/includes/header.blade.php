<nav class="nav-cabecera">
    <a href="{{ url('/') }}">
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
                <a href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
            </li>
            <li class="li-cabecera">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                @endif
            </li>
        @else
            <li class="li-cabecera">
                <a href="#" >
                    {{ Auth::user()->nombre}}, Perfil de usuario
                </a>
            </li>
            <li class="li-cabecera">
                <a href="{{ route('logout') }}"
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
    <form action="{{ url('foo/bar') }}" method="POST">
        <input type="text" placeholder="Buscar sitio web..." name="buscador">
        <button type="submit">Buscar</button>
    </form>
</div>