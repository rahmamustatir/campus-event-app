<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Campus Event Management</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-green-700">CAMPUS EVENT</h1>
            <p class="text-gray-500 text-sm">Management System</p>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email Institusi</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="nama@mahasiswa.unu.ac.id">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" id="password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="********">
            </div>

            <div class="flex items-center justify-between mb-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full focus:outline-none focus:shadow-outline transition duration-200">
                    LOGIN
                </button>
            </div>
        </form>

        <p class="text-center text-gray-600 text-sm mt-4">
            Belum punya akun? <a href="{{ route('register') }}" class="text-green-600 font-bold hover:underline">DAFTAR SEKARANG</a>
        </p>
    </div>

</body>
</html>