<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Notary System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('partials.navbar')

    <main class="container py-4">
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- VENDOSI KËTU NË FUND --}}
    @stack('scripts')
</body>
</html>
