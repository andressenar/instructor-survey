<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reportes</title>
    <link rel="stylesheet" href="{{ asset('/css/index.css') }}">
</head>

<body>
    <div class="container">
        <h1>Reporte de Instructores</h1>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Reporte por Fichas</th>
                    <th>Reporte General</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($instructors as $instructor)
                    <tr>
                        <td>{{ $instructor->name }}</td>
                        <td>
                            <button onclick="openModal({{ $instructor->id }})">
                                Ver Fichas Asociadas
                            </button>
                        </td>
                        <td>
                            <button>
                                <a href="{{ route('reports.general', $instructor->id) }}">
                                    Reporte General
                                </a>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($instructors as $instructor)
        <div id="modal-{{ $instructor->id }}" class="modal">
            <div class="modal-content">
                <h2>Fichas Asociadas a {{ $instructor->name }}</h2>
                <div class="ficha-list">
                    @foreach ($instructor->courses as $course)
                            <button>
                                <a
                                    href="{{ route('reports.show', ['courseId' => $course->id, 'instructorId' => $instructor->id, 'programId' => $course->program->id]) }}">
                                    {{ $course->code }}
                                </a>
                            </button>
                    @endforeach
                    </div>
                <button class="close-btn" onclick="closeModal({{ $instructor->id }})">Cerrar</button>
            </div>
        </div>
    @endforeach

    <script>
        function openModal(id) {
            document.getElementById(`modal-${id}`).style.display = 'flex';
        }

        function closeModal(id) {
            document.getElementById(`modal-${id}`).style.display = 'none';
        }
    </script>


</html>
