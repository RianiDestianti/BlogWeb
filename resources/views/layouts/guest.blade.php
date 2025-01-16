<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #e2e8f0; /* Warna latar belakang abu-abu */
            perspective: 1000px; /* Menambahkan perspektif untuk efek 3D */
        }
        .logo {
            width: 80px; /* Ukuran logo */
            height: 80px; /* Ukuran logo */
            border-radius: 50%; /* Membuat logo bulat */
            overflow: hidden; /* Memastikan konten di dalam tetap bulat */
            margin-bottom: 20px; /* Jarak bawah logo */
        }
        .form-container {
            background-color: #ffffff; /* Warna latar belakang form putih */
            border-radius: 8px; /* Sudut membulat */
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2); /* Bayangan untuk efek 3D */
            padding: 2rem; /* Padding di dalam form */
            transform: translateZ(0); /* Memastikan elemen dapat memiliki efek 3D */
            transition: transform 0.3s; /* Transisi untuk efek hover */
        }
        .form-container:hover {
            transform: translateY(-10px) scale(1.02); /* Efek hover untuk mengangkat form */
        }
        .form-title {
            font-size: 1.5rem; /* Ukuran font judul */
            font-weight: 600; /* Ketebalan font judul */
            margin-bottom: 1rem; /* Jarak bawah judul */
            text-align: center; /* Rata tengah */
            color: #4a5568; /* Warna teks judul abu-abu gelap */
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
       

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 form-container">
            <div class="form-title">
                {{ __('Login') }} <!-- Judul Form -->
            </div>

            {{ $slot }} <!-- Tempat untuk konten form login -->
        </div>
    </div>
</body>
</html>