<?php
namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function showSurvey($apprenticeId, $surveyId)
    {
        $survey = Survey::with('questions')->findOrFail($surveyId);
        $questions = $survey->questions;
        // Definir divisiones
        $divisions = [6, 4, 6, 4, 2];
        $currentPage = request()->get('page', 1);
    
        // Calcular el inicio y el límite
        $start = array_sum(array_slice($divisions, 0, $currentPage - 1));
        $limit = $divisions[$currentPage - 1] ?? $questions->count() - $start;
    
        $paginatedQuestions = $questions->slice($start, $limit);
    
        $hasMorePages = $start + $limit < $questions->count();
    
        $instructors = Auth::user()->course->instructors ?? [];
    
        return view('survey.form', compact('survey', 'paginatedQuestions', 'instructors', 'currentPage', 'hasMorePages', 'apprenticeId'));
    }
    

    public function storeAnswers(Request $request, $surveyId)
    {
        $data = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        foreach ($data['answers'] as $questionId => $answer) {
            if (!Auth::check()) {
                return redirect()->route('login.form')->withErrors(['error' => 'Debes iniciar sesión para completar la encuesta.']);
            }

            Answer::create([
                'qualification' => $answer,
                'apprentice_id' =>null,
                'question_id' => $questionId,
                'instructor_id' => $request->instructor_id,
            ]);
        }

        return redirect()->route('survey.complete')->with('success', 'Tus respuestas han sido guardadas correctamente');
    }

    public function submitSurvey(Request $request, $surveyId)
    {

        foreach ($request->answers as $instructorId => $questions) {
            foreach ($questions as $questionId => $answer) {
                Answer::create([
                    'apprentice_id' => null,
                    'instructor_id' => $instructorId,
                    'question_id' => $questionId,
                    'qualification' => is_array($answer) ? json_encode($answer) : $answer,
                ]);
            }
        }

        return redirect()->route('survey.complete');
    }

    public function complete()
    {
        return view('survey.complete');
    }

    

}
