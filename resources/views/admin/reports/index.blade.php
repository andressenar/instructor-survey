<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Reportes</title>
    <style>
        /* Estilo para la tabla */
        #reportTable {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Encabezado de la tabla */
        #reportTable thead th {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            text-align: left;
        }

        /* Filas alternas */
        #reportTable tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        #reportTable tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Hover en filas */
        #reportTable tbody tr:hover {
            background-color: #e0f7fa;
        }

        /* Paginación */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 8px 12px;
            margin: 2px;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #45a049;
            color: #e0f7fa
        }

        /* Caja de búsqueda */
        .dataTables_wrapper .dataTables_filter input {
            padding: 6px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        /* Información de la tabla */
        .dataTables_wrapper .dataTables_info {
            margin-top: 10px;
            color: #666;
        }

        /* Estilo para el mensaje de advertencia */
        .warning-message {
            width: 50%;
            color: #ff9900;
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>

<body class="font-sans bg-gray-100">
    <header class="bg-white text-gray-800 border-b border-gray-300 p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex justify-center">
                <img src="../img/logo-sena-verde-complementario-svg-2022.svg" alt="Logo SENA" class="w-12 h-12">
            </div>
            <h1 class="text-2xl font-semibold ml-4 flex-grow text-center md:text-left">Encuesta de Acompañamiento</h1>

            <div class="flex justify-end">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-green-500 hover:text-green-700">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </header>
    <!-- Mensaje de advertencia para caracteres inválidos -->
    <div id="warningMessage" class="warning-message">
            Para garantizar la precisión de los resultados, no se permite el uso de caracteres especiales en la búsqueda. Esto incluye símbolos como @, #, $, %, &, *, entre otros. Únicamente se aceptan letras, la letra "ñ" y espacios. Por favor, asegúrese de seguir estas directrices al realizar su búsqueda.
        </div>

    <div class="container mx-auto mt-6 px-4">
    <div id="warningMessage" class="warning-message">
            Para garantizar la precisión de los resultados, no se permite el uso de caracteres especiales en la búsqueda. Esto incluye símbolos como @, #, $, %, &, *, entre otros. Únicamente se aceptan letras, la letra "ñ" y espacios. Por favor, asegúrese de seguir estas directrices al realizar su búsqueda.
        </div>
        <!-- Tabla de Reportes -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Reporte de Instructores</h2>
            <button id="open-modal"
                class="px-6 py-3 text-white bg-[#38a901] rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                Cargue Masivo
            </button>
        </div>
        <table id="reportTable" class="display w-full table-auto text-sm text-left text-gray-600">
            <thead>
                <tr class="bg-gray-200 text-gray-800">
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Reporte por Fichas</th>
                    <th class="px-4 py-2">Reporte General</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($instructors as $instructor)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $instructor->name }} {{ $instructor->last_name }}
                            {{ $instructor->second_last_name }}</td>
                        <td class="px-4 py-2 text-center">
                            <button onclick="openModal({{ $instructor->id }})"
                                class="px-4 py-2 bg-[#38a901] text-white rounded-lg hover:bg-[#38a980] focus:outline-none">
                                Ver Fichas Asociadas
                            </button>
                        </td>

                        <td class="px-4 py-2 text-center">
                            <button @if (!$instructor->hasGeneralAnswers) disabled @endif>
                                <a href="{{ $instructor->hasGeneralAnswers ? route('reportsGeneral', $instructor->id) : '#' }} "
                                    class="px-4 py-2 rounded-lg focus:outline-none
                            @if ($instructor->hasGeneralAnswers) bg-[#38a901] text-white hover:bg-[#38a980]
                            @else bg-gray-400 text-white cursor-not-allowed @endif">
                                    Reporte General
                                </a>
                            </button>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        
    </div>

    <script>
        $(document).ready(function() {
            const table = $('#reportTable').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
                },
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                searchDelay: 200,
                responsive: true,
                autoWidth: false,

                initComplete: function(settings, json) {
                    const table = this.api();

                    // Extender la lógica de búsqueda para permitir "ñ" y "Ñ"
                    $.fn.DataTable.ext.type.search.string = function(data) {
                        return !data ? '' : data
                            .normalize("NFD") // Descompone los caracteres latinos con diacríticos
                            .replace(/[̀-ͯ]/g, "") // Elimina los diacríticos
                            .toLowerCase(); // Convierte todo a minúsculas
                    };

                    // Validar caracteres especiales
                    $('#reportTable_filter input').on('input', function() {
                        const invalidCharsPattern = /[^a-zA-ZñÑ\s]/g; // Bloquear caracteres especiales excepto letras, números, espacios y ñ/Ñ
                        const inputValue = $(this).val();

                        // Verificar si el patrón contiene caracteres inválidos
                        if (invalidCharsPattern.test(inputValue)) {
                            $('#warningMessage').show();  // Muestra el mensaje de advertencia
                            $(this).val(inputValue.replace(invalidCharsPattern, '')); // Elimina los caracteres inválidos
                        } else {
                            $('#warningMessage').hide();  // Oculta el mensaje de advertencia si no hay caracteres inválidos
                        }
                    });

                    table.draw();
                }
            });
        });
    </script>

</body>

</html>
