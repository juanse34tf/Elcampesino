<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - El Campesino</title>

    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100">

    <div class="flex min-h-screen items-center justify-center">

        <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">

            <h1 class="text-3xl font-bold text-center text-green-800 mb-6">
                El Campesino
            </h1>

            <form>

                <div class="mb-4">
                    <label class="block mb-2">
                        Usuario
                    </label>

                    <input
                        type="text"
                        class="w-full border rounded-lg p-3"
                        placeholder="Ingrese usuario">
                </div>

                <div class="mb-6">
                    <label class="block mb-2">
                        Contraseña
                    </label>

                    <input
                        type="password"
                        class="w-full border rounded-lg p-3"
                        placeholder="Ingrese contraseña">
                </div>

                <button
                    type="submit"
                    class="w-full bg-green-700 text-white p-3 rounded-lg">

                    Ingresar

                </button>

            </form>

        </div>

    </div>

</body>
</html>