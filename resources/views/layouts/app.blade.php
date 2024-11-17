<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $title)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"></head>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <header class="col-md-12 text-center">
        <h1> {{ $title }} </h1>
    </header>
    <main>
        <div class="row">
            <div class="col-md-2">
                <nav >
                    @include('partials.menu')
                </nav>
            </div>
            <div class="col-md-10">
                @yield('content')
            </div>
        </div>
    </main>
    <footer class="col-md-12">
        @include('partials.footer')
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script></body>
</html>
