<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte General - Instructor</title>
    <link rel="stylesheet" href="{{ asset('/css/show.css') }}">
</head>

<body>

    <div class="container">
        <h2>Reporte General de Encuestas</h2>
        <h3>Instructor: {{ $instructor->name }}</h3>
        <button id="Downloadpdf1">Descargar downloadCombinedPNG en alta calidad</button>
        <button id="downloadUnifiedPNG">Descargar Imagen Unificada</button>

        <div class="container-grafic">
            <div class="chart-section" id="chart1">
                <h2>1. Integralidad del Instructor</h2>
            </div>
            <div class="chart-section" id="chart2">
                <h2>2. Planeación del Procedimiento de Ejecución de la Formación</h2>
            </div>
            <div class="chart-section" id="chart3">
                <h2>3. Ejecución de la Formación Personal</h2>
            </div>
            <div class="chart-section" id="chart4">
                <h2>4. Evaluación General</h2>
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

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script>
    const { jsPDF } = window.jspdf;
      // Función para dividir el texto en varias líneas
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

document.addEventListener('DOMContentLoaded', function () {
    const reportData = @json($reportData->pluck('average')->values());
    const questions = JSON.parse(@json($questions)); // Convertimos JSON en un array

    // Comprobación para asegurarnos que questions es un array
    if (!Array.isArray(questions)) {
        console.error("La variable 'questions' no es un array:", questions);
    }

    const distribution = [6, 4, 6, 4]; // Cantidad de preguntas por gráfica
    let startIndex = 0;

    distribution.forEach((count, index) => {
        const chunkData = reportData.slice(startIndex, startIndex + count);
        const chunkCategories = questions
            .slice(startIndex, startIndex + count)  // Usamos slice aquí
            .map((q) => splitText(q, 23)); // Dividir el texto en líneas aquí

        startIndex += count;

        const options = {
            chart: {
                type: 'bar',
                height: 400,
                toolbar: {
                    show: false,
                },
            },
            series: [
                {
                    name: 'Promedio de Calificación',
                    data: chunkData,
                },
            ],
            xaxis: {
                categories: chunkCategories,
                labels: {
                    style: {
                        fontSize: '12px',
                        fontWeight: 'bold',
                    },
                },
            },
            yaxis: {
                title: {
                    text: 'Calificación Promedio',
                },
                min: 0,
                max: 5,
                labels: {
            formatter: function (val) {
                return val.toFixed(2); // Redondear a dos decimales
            },
        },
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val.toFixed(2);
                    },
                },
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
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
document.getElementById('Downloadpdf1').addEventListener('click', async function () {
    const content = document.querySelector(".container");

    if (!content) {
        console.error("No se encontró el contenedor '.content'.");
        return;
    }

    // Crear un canvas y renderizar el contenido de .content
    const scaleFactor = 1; // Reducir el escalado
    const canvasWidth = content.offsetWidth;
    const canvasHeight = content.offsetHeight;

    try {
        // Usar html2canvas para capturar el contenido
        const canvas = await html2canvas(content, {
            scale: scaleFactor,
            useCORS: true, // Permitir contenido externo si es necesario
        });

        // Convertir el canvas a imagen optimizada
        const imgData = canvas.toDataURL("image/png", 0.5); // Calidad optimizada (50%)

        // Reducción del ancho (ajustando a un porcentaje)
        const reducedWidth = canvas.width * 1; // Reducir el ancho al 80%
        const reducedHeight = canvas.height * (reducedWidth / canvas.width); // Mantener la proporción

        // Crear un PDF con las dimensiones reducidas
        const pdf = new jsPDF({
            orientation: "portrait",
            unit: "px",
            format: [reducedWidth, reducedHeight],
        });

        // Añadir la imagen al PDF con las dimensiones ajustadas
        pdf.addImage(imgData, "png", 0, 0, reducedWidth, reducedHeight);

        // Descargar el PDF
        pdf.save("content_reduced.pdf");

    } catch (error) {
        console.error("Error al generar el PDF:", error);
    }
});

document.getElementById('downloadpdf2').addEventListener('click', async function () {
    const content = document.querySelector(".container");

    if (!content) {
        console.error("No se encontró el contenedor '.content'.");
        return;
    }

    // Escala reducida para una imagen más liviana
    const scaleFactor = 1.5; // Reducir el escalado
    const canvasWidth = content.offsetWidth;
    const canvasHeight = content.offsetHeight;

    try {
        // Usar html2canvas para capturar el contenido
        const canvas = await html2canvas(content, {
            scale: scaleFactor,
            useCORS: true, // Permitir contenido externo si es necesario
        });

        // Convertir el canvas a imagen optimizada (formato PNG)
        const imgData = canvas.toDataURL("image/png", 0.5); // Reducir la calidad de la imagen (50%)

        // Crear un enlace de descarga
        const link = document.createElement('a');
        link.href = imgData;
        link.download = 'unified_content.png';

        // Simular un clic para descargar la imagen
        link.click();

// Crear un PDF con la imagen
const pdf = new jsPDF({
    orientation: "portrait",
    unit: "px",
    format: [canvasWidth, canvasHeight],
});

// Añadir la imagen al PDF
pdf.addImage(imgData, "PNG", 0, 0, canvasWidth, canvasHeight);

// Descargar el PDF
pdf.save("unified_content.pdf");

} catch (error) {
console.error("Error al generar la imagen o el PDF:", error);
}
});



</script>
        
    
</body>

</html>
