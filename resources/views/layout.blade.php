<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Go.Canteen')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
    <style>body { font-family: 'Segoe UI', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">
    @yield('content')
    @yield('scripts')
</body>
</html>