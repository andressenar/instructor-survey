<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta para Aprendices</title>
</head>
<body>

    <h1>Encuesta para Aprendices</h1>

    <form action="{{ route('survey.submit', $survey->id) }}" method="POST">
        @csrf

        <h3>{{ $survey->name }}</h3>
        <p>{{ $survey->description }}</p>

        @foreach ($questions as $question)
            <div>
                <label>{{ $question->question }}</label>
                <br>
                @foreach ($instructors as $instructor)
                    <div>
                        <label>{{ $instructor->name }}</label>
                        <br>
                        @for ($i = 1; $i <= 5; $i++)
                            <input type="radio" name="answers[{{ $question->id }}][{{ $instructor->id }}]" value="{{ $i }}" id="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $i }}">
                            <label for="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $i }}">{{ $i }}</label>
                        @endfor
                    </div>
                    <br>
                @endforeach
            </div>
            <br>
        @endforeach

        <button type="submit">Enviar Encuesta</button>
    </form>

</body>
</html>
