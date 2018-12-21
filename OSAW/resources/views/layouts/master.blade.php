<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="observatorio, accesibilidad, web, analisis, WCAG 2.0, WCAG 2.1, UNE 139803">
        <meta name="description" content="Observatorio para el Seguimiento de la Accesibilidad Web de sitios web que por ley deben de ser accesibles.">
        <meta name="author" content="Jesus F. Guijarro">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('titulo')</title>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        @yield('scripts')

        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
        
    </head>
    <body>
        <header class="cabecera">
            @include('includes.header')
        </header>

        <div class="contenido">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    @yield('content')
                </div>
            </div>
        </div>

        <footer class="pie">
            @include('includes.footer')
        </footer>
        <script src="{{ asset('js/bootstrap.js') }}"></script>
    </body>
</html>