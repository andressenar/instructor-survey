<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form action="{{ route('login.submit') }}" method="POST">
        @csrf
        <label for="course_id">Número de Ficha:</label>
        <input type="text" name="course_id" id="course_id" required>
        <br>
        <label for="identity_document">Cédula:</label>
        <input type="text" name="identity_document" id="identity_document" required>
        <br>
        <button type="submit">Ingresar</button>
    </form>
    @if ($errors->any())
        <div>
            <p>{{ $errors->first() }}</p>
        </div>
    @endif
</body>
</html>
