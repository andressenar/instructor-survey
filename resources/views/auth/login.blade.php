<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div>
            <label for="course_code">Código de curso:</label>
            <input type="text" id="course_code" name="course_code" required>
        </div>
        
        <div>
            <label for="identity_document">Cédula:</label>
            <input type="text" id="identity_document" name="identity_document" required>
        </div>
    
        <div>
            <button type="submit">Ingresar</button>
        </div>
    </form>
    @if ($errors->any())
        <div>
            <p>{{ $errors->first() }}</p>
        </div>
    @endif
</body>
</html>
