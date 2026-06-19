<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Tickets')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark px-4">
        <a class="navbar-brand" href="{{ route('tickets.index') }}">🎫 Ticket System</a>
        <form method="POST" action="/logout" class="m-0">
            @csrf
            <button class="btn btn-outline-light btn-sm">Logout</button>
        </form>
    </nav>

    <div class="container py-4">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @yield('content')
    </div>

    <div id="toast" class="alert shadow position-fixed"
        style="top:20px; right:20px; z-index:1080; display:none;"></div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @yield('scripts')
</body>

</html>