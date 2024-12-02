<script src="https://cdn.tailwindcss.com"></script>
<form action="{{ route('survey.submit', $survey->id) }}" method="POST" class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">
    @csrf

    <div class="max-w-4xl w-full bg-white shadow-lg rounded-lg p-6">

        <div x-data="{ page: 1 }">
            <!-- Página 1: Instrucciones -->
            <div :class="{ 'hidden': page !== 1 }">
                <h1 class="text-xl font-bold text-gray-800 mb-4 text-center">Encuesta de Acompañamiento</h1>
                <p class="text-gray-700 leading-relaxed mb-6 text-center">
                    <strong>Instrucciones:</strong><br>
                    A continuación encontrarás una serie de preguntas relacionadas con la experiencia recibida. Cada pregunta tiene una escala de valoración del 1 al 5.
                    <br><br>
                    Por favor, marca el número que refleje mejor tu experiencia. Al final encontrarás algunas preguntas abiertas para que puedas darnos más detalles.
                </p>
            </div>
        
            <!-- Página 2: Título y Escala -->
            <div :class="{ 'hidden': page !== 2 }">
                <h1 class="text-xl font-bold text-gray-800 mb-4 text-center">Valoración de la Experiencia - Parte 1</h1>
                <details class="mb-6">
                    <summary class="font-semibold bg-gray-200 text-gray-800 py-2 px-4 rounded-md cursor-pointer">
                        Escala de Valoración
                    </summary>
                    <div class="mt-2 text-sm text-gray-600">
                        <ul>
                            <li><strong>1: Muy insatisfecho / Muy en desacuerdo</strong></li>
                            <li><strong>2: Insatisfecho / En desacuerdo</strong></li>
                            <li><strong>3: Neutral / Ni de acuerdo ni desacuerdo</strong></li>
                            <li><strong>4: Satisfecho / De acuerdo</strong></li>
                            <li><strong>5: Muy satisfecho / Muy de acuerdo</strong></li>
                        </ul>
                    </div>
                </details>
                <!-- 6 preguntas de la página 2 -->
                <div id="question-container">
                    @foreach ($survey->questions->slice(0, 6) as $question)
                        <div class="mb-4">
                            <h4>{{ $question->question }}</h4>
                            @foreach ($instructors as $instructor)
                                <div class="flex w-full">
                                    <p><strong>Instructor: {{ $instructor->first_name }} {{ $instructor->last_name }}</strong></p>
                                    <div class="w-full text-sm text-left border-collapse border border-gray-300 rounded-lg">
                                        @if ($question->type == 'radio')
                                            @foreach ($question->options as $option)
                                                <input type="radio" class="h-5 w-5" name="answers[{{ $instructor->id }}][{{ $question->id }}]" value="{{ $option }}" id="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $option }}">
                                                <label for="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $option }}">{{ $option }}</label>
                                            @endforeach
                                        @elseif($question->type == 'text')
                                            <textarea name="answers[{{ $instructor->id }}][{{ $question->id }}]" id="question-{{ $question->id }}-instructor-{{ $instructor->id }}"></textarea>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        
            <!-- Página 3: Título y preguntas -->
            <div :class="{ 'hidden': page !== 3 }">
                <h1 class="text-xl font-bold text-gray-800 mb-4 text-center">Valoración de la Experiencia - Parte 2</h1>
                <!-- 4 preguntas de la página 3 -->
                <div id="question-container">
                    @foreach ($survey->questions->slice(6, 4) as $question)
                        <div class="mb-4">
                            <h4>{{ $question->question }}</h4>
                            @foreach ($instructors as $instructor)
                                <div class="flex w-full">
                                    <p><strong>Instructor: {{ $instructor->first_name }} {{ $instructor->last_name }}</strong></p>
                                    <div class="w-full text-sm text-left border-collapse border border-gray-300 rounded-lg">
                                        @if ($question->type == 'radio')
                                            @foreach ($question->options as $option)
                                                <input type="radio" class="h-5 w-5" name="answers[{{ $instructor->id }}][{{ $question->id }}]" value="{{ $option }}" id="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $option }}">
                                                <label for="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $option }}">{{ $option }}</label>
                                            @endforeach
                                        @elseif($question->type == 'text')
                                            <textarea name="answers[{{ $instructor->id }}][{{ $question->id }}]" id="question-{{ $question->id }}-instructor-{{ $instructor->id }}"></textarea>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Página 4: Título y preguntas -->
            <div :class="{ 'hidden': page !== 4 }">
                <h1 class="text-xl font-bold text-gray-800 mb-4 text-center">Valoración de la Experiencia - Parte 3</h1>
                <!-- 6 preguntas de la página 4 -->
                <div id="question-container">
                    @foreach ($survey->questions->slice(10, 6) as $question)
                        <div class="mb-4">
                            <h4>{{ $question->question }}</h4>
                            @foreach ($instructors as $instructor)
                                <div class="flex w-full">
                                    <p><strong>Instructor: {{ $instructor->first_name }} {{ $instructor->last_name }}</strong></p>
                                    <div class="w-full text-sm text-left border-collapse border border-gray-300 rounded-lg">
                                        @if ($question->type == 'radio')
                                            @foreach ($question->options as $option)
                                                <input type="radio" class="h-5 w-5" name="answers[{{ $instructor->id }}][{{ $question->id }}]" value="{{ $option }}" id="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $option }}">
                                                <label for="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $option }}">{{ $option }}</label>
                                            @endforeach
                                        @elseif($question->type == 'text')
                                            <textarea name="answers[{{ $instructor->id }}][{{ $question->id }}]" id="question-{{ $question->id }}-instructor-{{ $instructor->id }}"></textarea>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Página 5: Título y preguntas abiertas -->
            <div :class="{ 'hidden': page !== 5 }">
                <h1 class="text-xl font-bold text-gray-800 mb-4 text-center">Valoración Final</h1>
                <!-- 4 preguntas de la página 5 -->
                <div id="question-container">
                    @foreach ($survey->questions->slice(16, 4) as $question)
                        <div class="mb-4">
                            <h4>{{ $question->question }}</h4>
                            @foreach ($instructors as $instructor)
                                <div class="flex w-full">
                                    <p><strong>Instructor: {{ $instructor->first_name }} {{ $instructor->last_name }}</strong></p>
                                    <div class="w-full text-sm text-left border-collapse border border-gray-300 rounded-lg">
                                        @if ($question->type == 'radio')
                                            @foreach ($question->options as $option)
                                                <input type="radio" class="h-5 w-5" name="answers[{{ $instructor->id }}][{{ $question->id }}]" value="{{ $option }}" id="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $option }}">
                                                <label for="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $option }}">{{ $option }}</label>
                                            @endforeach
                                        @elseif($question->type == 'text')
                                            <textarea name="answers[{{ $instructor->id }}][{{ $question->id }}]" id="question-{{ $question->id }}-instructor-{{ $instructor->id }}"></textarea>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <!-- 2 preguntas abiertas -->
            
            </div>

             <!-- Página 2 -->
        <div :class="{ 'hidden': page !== 6 }">
            <h1 class="text-xl font-bold text-gray-800 mb-4 text-center">Preguntas Abiertas</h1>
            <!-- 2 preguntas de la página 6 -->
            <div id="question-container">
                @foreach ($survey->questions->slice(20, 2) as $question)
                    <div class="mb-4">
                        <h4>{{ $question->question }}</h4>
                        @foreach ($instructors as $instructor)
                            <div class="flex w-full">
                                <p><strong>Instructor: {{ $instructor->first_name }} {{ $instructor->last_name }}</strong></p>
                                <div class="w-full text-sm text-left border-collapse border border-gray-300 rounded-lg">
                                    @if ($question->type == 'radio')
                                        @foreach ($question->options as $option)
                                            <input type="radio" class="h-5 w-5" name="answers[{{ $instructor->id }}][{{ $question->id }}]" value="{{ $option }}" id="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $option }}">
                                            <label for="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $option }}">{{ $option }}</label>
                                        @endforeach
                                    @elseif($question->type == 'text')
                                        <textarea name="answers[{{ $instructor->id }}][{{ $question->id }}]" id="question-{{ $question->id }}-instructor-{{ $instructor->id }}"></textarea>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>


            <!-- Botones de navegación -->
            <div class="flex justify-between mt-6">
                <button type="button" @click="page--" :disabled="page === 1" class="bg-blue-500 text-white py-2 px-4 rounded">
                    Anterior
                </button>
                <button type="button" @click="page++" :disabled="page === 6" class="bg-blue-500 text-white py-2 px-4 rounded">
                    Siguiente
                </button>
            </div>

            <!-- Botón de envío -->
            <div class="flex justify-end mt-6" x-show="page === 6">
                <button type="submit" class="bg-green-500 text-white py-2 px-4 rounded">Enviar Encuesta</button>
            </div>

        </div>
        
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    </div>
</form>
