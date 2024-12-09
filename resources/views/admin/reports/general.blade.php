<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte General - Instructor</title>
    <style>
        @page {
            size: A4;
            margin-left: 3cm;
            margin-right: 2cm;
            margin-top: 2cm;
            margin-bottom: 2cm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .page-break {
            page-break-after: always;
        }

        .charts-container {
            display: block;
            margin-top: 20px;
            width: calc(100% - 5cm);
            /* Ancho total menos márgenes izquierdo y derecho */
        }

        .chart-section {
            width: 100%;
            margin-bottom: 15px;
        }

        .chart-section h2 {
            text-align: center;
            font-size: 14px;
        }

        .body{
            width: 100%,
        }
    </style>
</head>

<body class="body">
    <!-- Primera Hoja -->
    <div class="first-page">
        <h2 style="text-align: center;">Reporte General de Encuestas</h2>
        <h3 style="text-align: center;">Instructor: {{ $instructor->name }}</h3>

        <div class="charts-container">
            <div class="chart-section" id="chart1">
                <h2>1. Integralidad del Instructor</h2>
            </div>
            <div class="chart-section" id="chart2">
                <h2>2. Planeación del Procedimiento de Ejecución de la Formación</h2>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- Segunda Hoja -->
    <div class="second-page">
        <div class="charts-container">
            <div class="chart-section" id="chart3">
                <h2>3. Ejecución de la Formación Personal</h2>
            </div>
            <div class="chart-section" id="chart4">
                <h2>4. Evaluación General</h2>
            </div>
        </div>
    </div>

    <div class="page-break"></div>

    <!-- Observaciones y Recomendaciones -->
    <div class="observations-page">
        <h2 style="text-align: center; color: #28a745;">5. Observaciones y Recomendaciones</h2>

        <div style="display: flex; justify-content: space-between; gap: 20px;">
            <!-- Observaciones -->
            <div style="width: 48%;">
                <h3>Observaciones</h3>
                <ul>
                    @foreach ($observations->filter(fn($answer) => $answer->question_id == 21) as $observation)
                        <li>{{ $observation->qualification }}</li>
                    @endforeach
                </ul>
            </div>
            <!-- Recomendaciones -->
            <div style="width: 48%;">
                <h3>Recomendaciones</h3>
                <ul>
                    @foreach ($observations->filter(fn($answer) => $answer->question_id == 22) as $recommendation)
                        <li>{{ $recommendation->qualification }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        function splitText(text, maxLength) {
            const words = text.split(' '); // Dividimos el texto en palabras
            let lines = [];
            let currentLine = '';

            words.forEach((word) => {
                // Si agregar la palabra excede el límite de longitud, comenzamos una nueva línea
                if ((currentLine + word).length <= maxLength) {
                    currentLine += (currentLine ? ' ' : '') + word; // Añadimos la palabra al final de la línea
                } else {
                    lines.push(currentLine); // Añadimos la línea completa al array
                    currentLine = word; // Empezamos una nueva línea con la palabra actual
                }
            });

            // Agregamos la última línea
            if (currentLine) {
                lines.push(currentLine);
            }

            return lines;
        }
        document.addEventListener('DOMContentLoaded', function() {
            const reportData = @json($reportData->pluck('average')->values());
            const questions = JSON.parse(@json($questions)); // Convertimos JSON en un array


            // Función para dividir el texto en varias líneas
            // function splitText(text, maxLength) {
            //     const words = text.split(' '); // Dividimos el texto en palabras
            //     let lines = [];
            //     let currentLine = '';
            //     words.forEach((word) => {
            //         // Si agregar la palabra excede el límite de longitud, comenzamos una nueva línea
            //         if ((currentLine + word).length <= maxLength) {
            //             currentLine += (currentLine ? ' ' : '') +
            //             word; // Añadimos la palabra al final de la línea
            //         } else {
            //             lines.push(currentLine); // Añadimos la línea completa al array
            //             currentLine = word; // Empezamos una nueva línea con la palabra actual
            //         }
            //     });
            //     // Agregamos la última línea
            //     if (currentLine) {
            //         lines.push(currentLine);
            //     }
            //     return lines.join('\n'); // Unimos las líneas con un salto de línea
            // }

            const distribution = [6, 4, 6, 4]; // Cantidad de preguntas por gráfica
            let startIndex = 0;

            distribution.forEach((count, index) => {
                const chunkData = reportData.slice(startIndex, startIndex + count);
                const chunkCategories = questions
                    .slice(startIndex, startIndex + count)
                    .map((q) => splitText(q, 15)); // Dividir el texto en líneas aquí

                startIndex += count;

                const options = {
                    chart: {
                        type: 'bar',
                        height: '400',
                        width: '900', // Hacer que la gráfica ocupe el 100% del contenedor
                        toolbar: {
                            show: false,
                        },
                    },
                    series: [{
                        name: 'Promedio de Calificación',
                        data: chunkData,
                    }, ],
                    xaxis: {
                        categories: chunkCategories,
                        labels: {
                            style: {
                                fontSize: '12px',
                                fontWeight: 'bold',
                                whiteSpace: 'pre-line', // Importante para manejar saltos de línea
                            },
                            rotate: 0
                        },
                    },
                    yaxis: {
                        title: {
                            text: 'Calificación Promedio',
                        },
                        min: 0,
                        max: 5,
                        labels: {
                            formatter: function(val) {
                                return val.toFixed(2); // Redondear a dos decimales
                            },
                        },
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val.toFixed(2);
                            },
                        },
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val) {
                            return val.toFixed(2);
                        },
                        style: {
                            colors: ['#333'],
                        },
                    },
                };

                const chart = new ApexCharts(
                    document.querySelector(`#chart${index + 1}`),
                    options
                );
                chart.render();
            });
        });
    </script>

</body>

</html>
