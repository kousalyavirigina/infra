<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'RaKe Infra')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ time() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header>
    <div class="logo">
        <a href="javascript:history.back()">

        <!-- <a href="{{ route('home') }}"> -->
            <img src="{{ asset('assets/images/RAKE.jpg') }}">
        </a>
    </div>

    <nav class="navbar">
        <a href="{{ route('home') }}#about">About</a>
        <a href="{{ route('home') }}#services">Services</a>
        <a href="{{ route('home') }}#projects">Projects</a>
        <a href="{{ route('home') }}#contact">Contact</a>
        <a href="{{ route('feedback') }}">Feedback</a>

        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.plots.index') }}">Plots</a>
            @else
                <a href="{{ route('plots.index') }}">Plots</a>
            @endif
        @endauth
        @auth
            <a href="{{ route('bookings.index') }}">Bookings</a>
        @endauth


        @guest
            <a href="{{ route('login') }}">Login</a>
        @endguest

        @auth
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="logout-btn">Logout</button>
            </form>
        @endauth
    </nav>
</header>

<main>
    @yield('content')
</main>

</body>
</html>
