<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login SI Aset - UNMARIS' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full flex items-center justify-center p-4 antialiased text-gray-900 bg-gradient-to-br from-unmaris-900 to-unmaris-700">

    <!-- Panggil Toast untuk Notifikasi Error -->
    <x-toast />

    <div class="w-full max-w-md">
        {{ $slot }}
    </div>

</body>

</html>