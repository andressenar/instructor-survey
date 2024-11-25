<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
</head>
<body>

    <h1>Iniciar sesión</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login.submit') }}" method="POST">
        @csrf
        <label for="course_id">Número de Curso (ID del curso):</label>
        <input type="text" id="course_id" name="course_id" required>
        <br><br>
        
        <label for="identity_document">Número de Identificación:</label>
        <input type="text" id="identity_document" name="identity_document" required>
        <br><br>
        
        <button type="submit">Iniciar sesión</button>
    </form>

</body>
</html>
