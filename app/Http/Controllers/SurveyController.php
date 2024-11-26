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
        $survey = Survey::with('questions')->find($surveyId);
    $user = Auth::user();

    // Verificar que el aprendiz pertenece a un curso válido
    if (!$user->course) {
        abort(403, 'No estás inscrito en un curso válido.');
    }

    // Obtener instructores asociados al curso del aprendiz
    $instructors = $user->course->instructors;

    return view('survey.form', compact('survey', 'instructors'));
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
            if (!Auth::check()) {
                return redirect()->route('login.form')->withErrors(['error' => 'Debes iniciar sesión para completar la encuesta.']);
            }

            Answer::create([
                'qualification' => $answer,
                'apprentice_id' => Auth::id(),
                'question_id' => $questionId,
                'instructor_id' => $request->instructor_id, // Asegúrate de que este dato venga del formulario
            ]);
        }

        // Redirigir con mensaje de éxito
        return redirect()->route('survey.complete')->with('success', 'Tus respuestas han sido guardadas correctamente');
    }

    public function submitSurvey(Request $request, $surveyId)
    {
        $apprenticeId = Auth::user()->id; // Obtener el aprendiz autenticado

        foreach ($request->answers as $instructorId => $questions) {
            foreach ($questions as $questionId => $answer) {
                Answer::create([
                    'apprentice_id' => $apprenticeId,
                    'instructor_id' => $instructorId,
                    'question_id' => $questionId,
                    'qualification' => is_array($answer) ? json_encode($answer) : $answer, // Manejo de texto o radio
                ]);
            }
        }

        return redirect()->route('survey.complete');
    }


    public function complete()
    {
        return view('survey.complete'); // Asegúrate de crear esta vista
    }
}
