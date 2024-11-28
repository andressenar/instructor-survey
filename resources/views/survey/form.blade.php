<script src="https://cdn.tailwindcss.com"></script>
<form action="{{ route('survey.submit', $survey->id) }}" method="POST"
    class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">
    @csrf

    <div class="max-w-4xl w-full bg-white shadow-lg rounded-lg p-6">

        <!-- Escala de valoración -->
        <details class="mb-6">
            <summary class="font-semibold bg-gray-200 text-gray-800 py-2 px-4 rounded-md cursor-pointer">
                Escala de Valoración
            </summary>
            <div class="mt-2 text-sm text-gray-600">
                <ul>
                    <li><strong>1: Muy insatisfecho / Muy en desacuerdo</strong> </li>
                    <li><strong>2: Insatisfecho / En desacuerdo</strong></li>
                    <li><strong>3: Neutral / Ni de acuerdo ni desacuerdo</strong> </li>
                    <li><strong>4: Satisfecho / De acuerdo</strong> </li>
                    <li><strong>5: Muy satisfecho / Muy de acuerdo</strong></li>
                </ul>
            </div>
        </details>


        @if ($survey->questions->isEmpty())
            <p>No hay preguntas disponibles para esta encuesta.</p>
        @else
            @foreach ($survey->questions as $question)
                <div>
                    <h4>{{ $question->question }}</h4>
                    @if ($instructors->isEmpty())
                        <p>No hay instructores disponibles para esta encuesta.</p>
                    @else
                        @foreach ($instructors as $instructor)
                            <div class="flex w-full">
                                <p><strong>Instructor: {{ $instructor->first_name }}
                                        {{ $instructor->last_name }}</strong></p>
                                <div class="w-full text-sm text-left border-collapse border border-gray-300 rounded-lg">
                                  @if ($question->type == 'radio')
                                  @foreach ($question->options as $option)
                                  <input type="radio"
                                    class="h-5 w-5" name="answers[{{ $instructor->id }}][{{ $question->id }}]"
                                    value="{{ $option }}"
                                    id="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $option }}">
                                    <label
                                        for="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $option }}">{{ $option }}</label>
                        @endforeach
                    @elseif($question->type == 'text')
                        <textarea name="answers[{{ $instructor->id }}][{{ $question->id }}]"
                            id="question-{{ $question->id }}-instructor-{{ $instructor->id }}"></textarea>
                    @endif
                </div>
    </div>
    @endforeach
    @endif
    </div>
    @endforeach
    @endif
    <!-- Botón de navegación -->
    <div class="flex justify-end mt-6">
        <button type="submit" >Enviar Encuesta</button>
    </div>
    </div>
</form>
