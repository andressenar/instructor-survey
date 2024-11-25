<?php
namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Apprentice;
use App\Models\Instructor;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SurveyController extends Controller
{
    // Muestra la encuesta para un aprendiz
    public function showSurvey($apprenticeId, $surveyId)
    {
        // Obtener el aprendiz y la encuesta
        $apprentice = Apprentice::findOrFail($apprenticeId);
        $survey = Survey::findOrFail($surveyId);

        // Obtener el curso asociado al aprendiz
        $course = $apprentice->course; // Ahora obtenemos el curso relacionado con el aprendiz

        // Obtener los instructores asociados al curso
        $instructors = $course->instructors; // Acceder a los instructores del curso

        // Obtener las preguntas de la encuesta
        $questions = $survey->questions;

        // Pasar la información a la vista
        return view('survey.form', compact('apprentice', 'survey', 'instructors', 'questions'));
    }

    // Almacena las respuestas de un aprendiz
    public function storeAnswers(Request $request, $surveyId)
    {
        // Validación de las respuestas
        $data = $request->validate([
            'answers' => 'required|array', // Aseguramos que sea un array
            'answers.*' => 'required|string', // Aseguramos que cada respuesta sea una cadena (tanto texto como radio)
        ]);

        // Procesamos cada respuesta
        foreach ($data['answers'] as $questionId => $answer) {
            // Guardamos las respuestas en la base de datos
            Answer::create([
                'qualification' => $answer,  // Guardamos el valor de la respuesta (texto o opción de radio)
                'apprentice_id' => Auth::user()->id, // Asumimos que el aprendiz está autenticado
                'question_id' => $questionId, // ID de la pregunta
            ]);
        }

        // Redirigir con mensaje de éxito
        return redirect()->route('survey.complete')->with('success', 'Tus respuestas han sido guardadas correctamente');
    }
}
