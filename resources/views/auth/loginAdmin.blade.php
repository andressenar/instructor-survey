<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta SENA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <div class="flex flex-col lg:flex-row items-center justify-center min-h-screen bg-white">
        <!-- Imagen ilustrativa  -->
        <div class="hidden w-2/5 h-full bg-cover lg:block">
            <img src="../img/imagen.png" alt="Imagen ilustrativa" class="w-80 h-auto">
        </div>

        <!-- Formulario a la derecha -->
        <div class="flex items-center justify-center w-full max-w-md p-8 bg-white rounded-lg shadow-md lg:w-3/5">
            <div class="w-full space-y-6">

                <!-- Logo -->
                <div class="flex justify-center">
                    <img src="../img/logo-sena-verde-complementario-svg-2022.svg" alt="Logo SENA" class="w-20 h-20">
                </div>

                <!-- Título -->
                <h1 class="text-2xl font-bold text-center text-gray-700">Encuesta de Acompañamiento y Satisfacción</h1>

                <!-- Formulario -->
                <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">

                    @csrf

                    <!-- Documento de Identidad -->
                    <div>
                        <label for="documento" class="block text-sm font-medium text-gray-600">Usuario</label>
                        <input type="text" id="identity_document" name="identity_document" placeholder="Ingresa tu documento" class="block w-full px-4 py-2 mt-1 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:ring focus:ring-green-300 focus:outline-none" required>
                    </div>

                    <!-- Ficha -->
                    <div>
                        <label for="ficha" class="block text-sm font-medium text-gray-600">Contraseña</label>
                        <div class="relative">
                            <!-- Campo de contraseña -->
                            <input type="password" id="course_code" name="course_code" placeholder="Ingresa tu contraseña"
                                class="block w-full px-4 py-2 mt-1 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:ring focus:ring-green-300 focus:outline-none"
                                required>

                            <!-- Ícono de ojo (FontAwesome) -->
                            <span class="absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer text-gray-500" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Botón Ingresar -->
                    <button type="submit" class="w-full px-4 py-2 text-white bg-[#38a901] rounded-lg hover:bg-[#38a901] focus:ring focus:ring-green-300">
                        INGRESAR
                    </button>
                </form>

                <!-- Muestra cualquier error de validación si existe -->
                @if ($errors->any())
                    <div>
                        <!-- Muestra el primer mensaje de error -->
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif

                <div class="text-center">
                   <p class="text-sm text-gray-500">Ingresar como <a href="{{ route('login') }}" class="text-green-500 hover:underline">Aprendiz</a></p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('course_code');

    togglePassword.addEventListener('click', function (e) {
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;

        if (type === 'password') {
            togglePassword.innerHTML = `<i class="fas fa-eye"></i>`; // Ojo cerrado
        } else {
            togglePassword.innerHTML = `<i class="fas fa-eye-slash"></i>`; // Ojo abierto
        }
    });
</script>
