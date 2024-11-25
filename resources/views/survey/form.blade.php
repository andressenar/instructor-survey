// resources/views/survey/form.blade.php

<form action="{{ route('survey.submit', $survey->id) }}" method="POST">
    @csrf
    <h3>{{ $survey->name }}</h3>
    <p>{{ $survey->description }}</p>

    @foreach ($survey->questions as $question)
        <div>
            <label>{{ $question->question }}</label>
            <br>
            @if($question->type == 'radio')
                @foreach ($question->options as $option)
                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" id="question-{{ $question->id }}-{{ $option }}">
                    <label for="question-{{ $question->id }}-{{ $option }}">{{ $option }}</label>
                @endforeach
            @elseif($question->type == 'text')
                <textarea name="answers[{{ $question->id }}]" id="question-{{ $question->id }}"></textarea>
            @endif
        </div>
    @endforeach

    <button type="submit">Enviar Encuesta</button>
</form>