<script src="https://cdn.tailwindcss.com"></script>
<form action="{{ route('survey.submit', $survey->id) }}" method="POST" class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">
    @csrf
    <div class="max-w-4xl w-full bg-white shadow-lg rounded-lg p-6">
        <!-- Título de la encuesta -->
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Encuesta: {{ $survey->name }}</h1>

        <!-- Escala de Valoración -->
        <details class="mb-6 bg-gray-200 p-4 rounded-md">
            <summary class="font-semibold text-gray-800 cursor-pointer">
                Escala de Valoración
            </summary>
            <div class="mt-2 text-sm text-gray-600">
                <ul class="list-disc pl-5">
                    <li><strong>1:</strong> Muy insatisfecho / Muy en desacuerdo</li>
                    <li><strong>2:</strong> Insatisfecho / En desacuerdo</li>
                    <li><strong>3:</strong> Neutral / Ni de acuerdo ni en desacuerdo</li>
                    <li><strong>4:</strong> Satisfecho / De acuerdo</li>
                    <li><strong>5:</strong> Muy satisfecho / Muy de acuerdo</li>
                </ul>
            </div>
        </details>

        

        <!-- Sección de preguntas: INTEGRALIDAD DEL INSTRUCTOR -->
        @foreach ($paginatedQuestions as $index => $question)
            @if ($index < 6) <!-- Primer grupo de 7 preguntas -->
                @if ($loop->first)
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">1. INTEGRALIDAD DEL INSTRUCTOR</h2>
                @endif

                <div>
                    <h2 class="text-base font-semibold text-gray-700">{{ $question->question }}</h2>
                </div>

                <div>
                    <table class="w-full text-sm text-left mb-4 bg-gray-50 rounded-lg border-collapse border ">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="border border-gray-300 p-2 text-center">Instructor</th>
                                @foreach ($question->options as $option)
                                    <th class="border border-gray-300 p-2 text-center">{{ $option }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @if ($instructors->isEmpty())
                                <tr class="bg-gray-200 text-gray-700">
                                    <strong>No hay instructores para esta ficha.</strong>
                                </tr>
                            @else
                                @foreach ($instructors as $instructor)
                                    <tr>
                                        <td class="border border-gray-300 p-2">{{ $instructor->first_name }} {{ $instructor->middle_name }} {{ $instructor->last_name }} {{ $instructor->second_last_name }}</td>
                                        @foreach ($question->options as $option)
                                            <td class="border border-gray-300 p-2 text-center">
                                                <input type="radio"
                                                    name="answers[{{ $instructor->id }}][{{ $question->id }}]"
                                                    id="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $option }}"
                                                    class="h-5 w-5">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            @endif
        @endforeach

        <!-- Sección de preguntas: PLANEACION -->
        @foreach ($paginatedQuestions as $index => $question)
            @if ($index >= 6 && $index < 11) <!-- Segundo grupo de 4 preguntas -->
                @if ($loop->first)
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">2. PLANEACION DEL PROCEDIMIENTO DE EJECUCION DE LA FORMACION</h2>
                @endif
                
                <div class="mb-4">
                    <h2 class="text-base font-semibold text-gray-700">{{ $question->question }}</h2>
                    <table class="w-full text-sm text-left border-collapse border border-gray-300 rounded-lg">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="border border-gray-300 p-2 text-center">Instructor</th>
                                @foreach ($question->options as $option)
                                    <th class="border border-gray-300 p-2 text-center">{{ $option }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @if ($instructors->isEmpty())
                                <tr class="bg-gray-200 text-gray-700">
                                    <strong>No hay instructores para esta ficha.</strong>
                                </tr>
                            @else
                                @foreach ($instructors as $instructor)
                                    <tr>
                                        <td class="border border-gray-300 p-2">{{ $instructor->first_name }} {{ $instructor->middle_name }} {{ $instructor->last_name }} {{ $instructor->second_last_name }}</td>
                                        @foreach ($question->options as $option)
                                            <td class="border border-gray-300 p-2 text-center">
                                                <input type="radio"
                                                    name="answers[{{ $instructor->id }}][{{ $question->id }}]"
                                                    id="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $option }}"
                                                    class="h-5 w-5">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            @endif
        @endforeach

        <!-- Sección de preguntas: EJECUCION -->
        @foreach ($paginatedQuestions as $index => $question)
            @if ($index >= 11 && $index < 16) <!-- Tercer grupo de 6 preguntas -->
                @if ($loop->first)
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">3. EJECUCION DE LA FORMACION PROFESIONAL</h2>
                @endif
                <div class="mb-4">
                    <h2 class="text-base font-semibold text-gray-700">{{ $question->question }}</h2>
                    <table class="w-full text-sm text-left border-collapse border border-gray-300 rounded-lg">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="border border-gray-300 p-2 text-center">Instructor</th>
                                @foreach ($question->options as $option)
                                    <th class="border border-gray-300 p-2 text-center">{{ $option }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @if ($instructors->isEmpty())
                                <tr class="bg-gray-200 text-gray-700">
                                    <strong>No hay instructores para esta ficha.</strong>
                                </tr>
                            @else
                                @foreach ($instructors as $instructor)
                                    <tr>
                                        <td class="border border-gray-300 p-2">{{ $instructor->first_name }} {{ $instructor->middle_name }} {{ $instructor->last_name }} {{ $instructor->second_last_name }}</td>
                                        @foreach ($question->options as $option)
                                            <td class="border border-gray-300 p-2 text-center">
                                                <input type="radio"
                                                    name="answers[{{ $instructor->id }}][{{ $question->id }}]"
                                                    id="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $option }}"
                                                    class="h-5 w-5">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            @endif
        @endforeach

        <!-- Sección de preguntas: EVALUACION -->
        @foreach ($paginatedQuestions as $index => $question)
            @if ($index >= 16 && $index < 20) <!-- Tercer grupo de  preguntas -->
                @if ($loop->first)
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">4. EVALUACION</h2>
                @endif
                <div class="mb-4">
                    <h2 class="text-base font-semibold text-gray-700">{{ $question->question }}</h2>
                    <table class="w-full text-sm text-left border-collapse border border-gray-300 rounded-lg">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="border border-gray-300 p-2 text-center">Instructor</th>
                                @foreach ($question->options as $option)
                                    <th class="border border-gray-300 p-2 text-center">{{ $option }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @if ($instructors->isEmpty())
                                <tr class="bg-gray-200 text-gray-700">
                                    <strong>No hay instructores para esta ficha.</strong>
                                </tr>
                            @else
                                @foreach ($instructors as $instructor)
                                    <tr>
                                        <td class="border border-gray-300 p-2">{{ $instructor->first_name }} {{ $instructor->middle_name }} {{ $instructor->last_name }} {{ $instructor->second_last_name }}</td>
                                        @foreach ($question->options as $option)
                                            <td class="border border-gray-300 p-2 text-center">
                                                <input type="radio"
                                                    name="answers[{{ $instructor->id }}][{{ $question->id }}]"
                                                    id="question-{{ $question->id }}-instructor-{{ $instructor->id }}-{{ $option }}"
                                                    class="h-5 w-5">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            @endif
        @endforeach

        <!-- Sección de preguntas: OBSERVACION Y RECOMENDACION O SUGERENCIAS -->
        @foreach ($paginatedQuestions as $index => $question)
            @if ($index >= 20) <!-- Último grupo de preguntas restantes -->
                @if ($loop->first)
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">5. OBSERVACION Y RECOMENDACION O SUGERENCIAS</h2>
                @endif
                <div class="mb-4">
                    <h2 class="text-base font-semibold text-gray-700">{{ $question->question }}</h2>
                    <table class="w-full text-sm text-left border-collapse border border-gray-300 rounded-lg">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700">
                                <th class="border border-gray-300 p-2 text-center">Instructores</th>
                                <th class="border border-gray-300 p-2 text-center">Observacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($instructors->isEmpty())
                            <tr>
                                <strong>No hay instructores para realizar la observacion.</strong>
                            </tr>
                            @else
                            @foreach ($instructors as $instructor)
                            <tr>
                                <td class="border border-gray-300 p-2">{{ $instructor->first_name }} {{ $instructor->middle_name }} {{ $instructor->last_name }} {{ $instructor->second_last_name }}</td>
                               
                                <td class="border border-gray-300 p-2 text-center">
                                <textarea class="w-full h-full"
                                        name="answers[{{ $instructor->id }}][{{ $question->id }}]" 
                                        id="question-{{ $question->id }}-instructor-{{ $instructor->id }}"
                                        placeholder="Comenta aqui">
                               </textarea>
                                 </td>
                               
                            </tr>
                                
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            @endif
        @endforeach

        <!-- Navegación -->
        <div class="flex justify-end items-center mt-6 space-x-4">
            @if ($currentPage > 1)
                <a href="{{ route('survey.show', [$apprenticeId, $survey->id, 'page' => $currentPage - 1]) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Anterior
                </a>
            @endif
        
            @if ($hasMorePages)
                <a href="{{ route('survey.show', [$apprenticeId, $survey->id, 'page' => $currentPage + 1]) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
                    Siguiente
                </a>
            @else
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Enviar Encuesta
                </button>
            @endif
        </div>
        
        
    </div>
</form>
