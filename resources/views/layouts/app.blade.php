<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Latin Electrical')
    </title>

    <link rel="icon" href="{{ asset('images/logo/favicon-32x32.png') }}">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    @stack('styles')
</head>

<body>

<div class="admin-wrapper">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    <div class="main-wrapper">

        {{-- Navbar --}}
        @include('partials.navbar')

        {{-- Page Content --}}
        <main class="main-content">

            @yield('content')

        </main>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="{{ asset('js/admin.js') }}"></script>

@stack('scripts')

</body>
</html>