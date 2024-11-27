<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reportes</title>
</head>
<body>
    <div class="container">
        <h1>Reportes de Encuestas</h1>
        <ul>
            @foreach($courses as $course)
                <li>
                    <strong>{{ $course->name }}</strong>
                    <ul>
                        @foreach($course->instructors as $instructor)
                            <li>
                                <a href="{{ route('reports.show', [$course->id, $instructor->id]) }}">
                                    {{ $instructor->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
