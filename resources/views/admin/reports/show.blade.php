<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte-instructor</title>
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
</head>

<body>
    <div class="container">
        <h2>Reporte de la Ficha: {{ $course->code }}</h2>
        <h3>Instructor: {{ $instructor->name }}</h3>
        <h3>programa:{{ $program->name }}</h3>

        <div class="container-grafic">
            <div class="chart-section" id="chart1">
                <h2>1.Integralidad del instructor</h2>
            </div>
            <div class="chart-section" id="chart2">
                <h2>2.Planeacion del procedimiento de ejecucion de la formación</h2>
            </div>
            <div class="chart-section" id="chart3">
                <h2>3.Ejecucion de la formacion personal</h2>
            </div>
            <div class="chart-section" id="chart4">
                <h2>4.Evaluacion</h2>
            </div>
            <div class="chart-section"
                style="padding: 20px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <h2 style="text-align: center; color: #28a745;">5. Observaciones y Recomendaciones</h2>

                <div style="display: flex; justify-content: space-between; gap: 20px;">
                    <!-- Observaciones -->
                    <div
                        style="width: 48%; background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                        <h3 style="color: #28a745; border-bottom: 2px solid#28a745; padding-bottom: 8px;">Observaciones
                        </h3>
                        <ul style="list-style: none; padding: 0;">
                            @foreach ($observations->filter(fn($answer) => $answer->question_id == 21) as $observation)
                                <li
                                    style="background-color:  #e9fbe8; padding: 10px; margin-bottom: 8px; border-radius: 5px;">
                                    {{ $observation->qualification }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Recomendaciones -->
                    <div
                        style="width: 48%; background-color: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                        <h3 style="color: #28a745; border-bottom: 2px solid #28a745; padding-bottom: 8px;">
                            Recomendaciones</h3>
                        <ul style="list-style: none; padding: 0;">
                            @foreach ($observations->filter(fn($answer) => $answer->question_id == 22) as $recommendation)
                                <li
                                    style="background-color: #e9fbe8; padding: 10px; margin-bottom: 8px; border-radius: 5px;">
                                    {{ $recommendation->qualification }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const reportData = @json($reportData->pluck('average')->values());
            const questions = @json($questions->values());

            const distribution = [6, 4, 6, 4]; // Cantidad de preguntas por gráfica
            let startIndex = 0;

            distribution.forEach((count, index) => {
                const chunkData = reportData.slice(startIndex, startIndex + count);
                const chunkCategories = questions.slice(startIndex, startIndex + count).map(q => {
                    // Limita el texto a 20 caracteres y agrega "..." si es más largo
                    return q.length > 20 ? q.substring(0, 25) + '...' : q;
                });
                startIndex += count;

                const options = {
                    chart: {
                        type: 'bar',
                        height: 400,
                        toolbar: {
                            show: false
                        },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800,
                        }
                    },
                    colors: ['#4CAF50'],
                    series: [{
                        name: 'Promedio de Calificación',
                        data: chunkData
                    }],
                    xaxis: {
                        categories: chunkCategories,
                        title: {
                            text: 'Preguntas'
                        },
                        labels: {
                            rotate: 0,
                            style: {
                                fontSize: '12px',
                                fontWeight: 'bold',
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Calificación Promedio'
                        },
                        min: 0,
                        max: 5
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val.toFixed(2);
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val) {
                            return val.toFixed(2);
                        },
                        style: {
                            colors: ['#333']
                        }
                    }
                };

                const chart = new ApexCharts(document.querySelector(`#chart${index + 1}`), options);
                chart.render();
            });
        });
    </script>
</body>

</html>