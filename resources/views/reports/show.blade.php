<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte-instructor</title>
</head>

<body>

    <div class="container">
        <h2>Reporte del Curso: {{ $course->code }}</h2>
        <h3>Instructor: {{ $instructor->first_name }}</h3>
        <h3>programa:{{ $program->name }}</h3>

        <div id="chart"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var options = {
                chart: {
                    type: 'bar',  // Tipo de gráfico: 'bar', 'pie', 'line', etc.
                    height: 400
                },
                series: [{
                    name: 'Promedio de Calificación',
                    data: @json($reportData->pluck('average')->values()) // Promedios de calificaciones
                }],
                xaxis: {
                    categories: @json($questions->values()),  // Preguntas como categorías
                    title: {
                        text: 'Preguntas'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Calificación Promedio'
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val.toFixed(2);
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        });
    </script>


</body>

</html>
