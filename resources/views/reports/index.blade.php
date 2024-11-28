<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reportes</title>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

    var options = {
        series: [{
        data: [44, 55, 41, 64, 22, 43, 21]
      }, {
        data: [53, 32, 33, 52, 13, 44, 32]
      }],
        chart: {
        type: 'bar',
        height: 430
      },
      plotOptions: {
        bar: {
          horizontal: true,
          dataLabels: {
            position: 'top',
          },
        }
      },
      dataLabels: {
        enabled: true,
        offsetX: -6,
        style: {
          fontSize: '12px',
          colors: ['#fff']
        }
      },
      stroke: {
        show: true,
        width: 1,
        colors: ['#fff']
      },
      tooltip: {
        shared: true,
        intersect: false
      },
      xaxis: {
        categories: [2001, 2002, 2003, 2004, 2005, 2006, 2007],
      },
      };

      var chart = new ApexCharts(document.querySelector("#chart"), options);
      chart.render();
    });
</script>
</head>

<body>
    <div id="chart"></div>
    <div class="container">
        <h1>Reportes de Encuestas</h1>
        <table>
            <thead>
                <tr>
                    <th>preguntas</th>
                    <th>respuestas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $question)
                    <tr>
                        <td>{{$question->question}}</td>
                        <td>
                            @foreach ($question->answers as $answer)
                            {{$answer->qualification}}

                            @endforeach
                        </td>
                    </tr>
                @endforeach


            </tbody>
        </table>

    </div>
</body>

</html>
