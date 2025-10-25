<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <aside>
        <div class="logo">
            <img src="{{ asset("assets/img/logo-project.png") }}" width="44px" alt="" >
        </div>
        <nav>
            <ul>
                <li><a href=""></a></li>
            </ul>
        </nav>
    </aside>
    <main>
        <header>
            
        </header>
        @yield('content')
    </main>
</body>
</html>