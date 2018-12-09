<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="description" content="Head page">

    <title>@yield('titulo')</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<div class="container">

    <header class="row">
        @include('includes.header')
    </header>

    <div id="main" class="row">

            @yield('content')

    </div>

    <footer class="row">
        @include('includes.footer')
    </footer>

</div>
</body>
</html>