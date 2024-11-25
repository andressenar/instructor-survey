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
        // Validación de los datos del formulario
        $data = $request->validate([
            'answers' => 'required|array',
            'answers.*.*' => 'required|in:1,2,3,4,5', // Validar que las respuestas sean entre 1 y 5
        ]);
    
        // Guardar las respuestas
        foreach ($data['answers'] as $questionId => $instructors) {
            foreach ($instructors as $instructorId => $qualification) {
                Answer::create([
                    'qualification' => $qualification,
                    'apprentice_id' => Auth::user()->id, // Asumiendo que el aprendiz está autenticado
                    'instructor_id' => $instructorId,
                    'question_id' => $questionId,
                ]);
            }
        }
    
        // Redirigir con mensaje de éxito
        return redirect()->route('survey.complete')->with('success', 'Tus respuestas han sido guardadas correctamente');
    }
}
