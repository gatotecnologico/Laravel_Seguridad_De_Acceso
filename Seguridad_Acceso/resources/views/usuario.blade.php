<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-50 via-white to-purple-50 flex items-center justify-center min-h-screen p-4"
    style="font-family: 'Inter', sans-serif;">
    <div class="w-full max-w-md bg-white/70 backdrop-blur-lg p-8 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/60">
        <h1 class="text-2xl font-semibold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
            Bienvenido
        </h1>
        <h2 class="text-2xl font-semibold bg-gradient-to-r from-green-500 to-green-700 bg-clip-text text-transparent">
            {{ $usuarioModelo->getCorreo() }}
        </h2>
        <div class="mt-6 bg-white rounded-lg shadow-md overflow-hidden">
            <img src="imgs/caballo.webp" alt="caballo foto" class="w-full h-auto object-cover">
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $usuario->getCorreo() }}">
            <button type="submit"
                class="mt-6 w-full py-3 px-4 bg-gradient-to-r from-red-500 to-red-600 text-white font-medium rounded-xl hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 transition duration-200 shadow-lg shadow-red-500/30">
                Cerrar Sesión
            </button>
        </form>
    </div>
</body>

</html>

