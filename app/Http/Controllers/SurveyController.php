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
        $survey = Survey::with('questions')->find($surveyId);
        $user = Auth::user();

        // Verificar si el usuario está inscrito en un curso
        if (!$user->course) {
            abort(403, 'No estás inscrito en un curso válido.');
        }

        // Obtener los instructores del curso
        $instructors = $user->course->instructors;

        return view('survey.form', compact('survey', 'instructors'));
    }
    

    public function storeAnswers(Request $request, $surveyId)
    {
        $data = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
            'instructor_id' => 'required|exists:instructors,id',
        ]);

        $user = Auth::user();

        // Verificar si el usuario está inscrito en un curso
        if (!$user->course) {
            return redirect()->route('survey.form')->withErrors(['error' => 'No estás inscrito en un curso válido.']);
        }

        // Obtener el curso del usuario autenticado
        $course = $user->course;

        // Guardar las respuestas con el course_id
        foreach ($data['answers'] as $questionId => $answer) {
            if (!Auth::check()) {
                return redirect()->route('login.form')->withErrors(['error' => 'Debes iniciar sesión para completar la encuesta.']);
            }

            Answer::create([
                'qualification' => $answer,
                'apprentice_id' =>null,
                'question_id' => $questionId,
                'instructor_id' => $data['instructor_id'],
                'course_id' => $course->id, // Asignar el course_id
            ]);
        }

        return redirect()->route('survey.complete')->with('success', 'Tus respuestas han sido guardadas correctamente');
    }

    public function submitSurvey(Request $request, $surveyId)
    {
        $user = Auth::user();

        // Verificar si el usuario está inscrito en un curso
        if (!$user->course) {
            return redirect()->route('survey.form')->withErrors(['error' => 'No estás inscrito en un curso válido.']);
        }

        // Obtener el curso del usuario autenticado
        $course = $user->course;

        // Guardar las respuestas con el course_id
        foreach ($request->answers as $instructorId => $questions) {
            foreach ($questions as $questionId => $answer) {
                Answer::create([
                    'apprentice_id' => null,
                    'instructor_id' => $instructorId,
                    'question_id' => $questionId,
                    'qualification' => is_array($answer) ? json_encode($answer) : $answer,
                    'course_id' => $course->id, // Asignar el course_id
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


/* 
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

        $courseId = session('course_id');
    
        $instructors = Auth::user()->course->instructors ?? [];
    
        return view('survey.form', compact('survey', 'paginatedQuestions', 'instructors', 'currentPage', 'hasMorePages', 'apprenticeId', 'courseId'));
    }
    

    public function storeAnswers(Request $request, $surveyId)
    {
        $data = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
            'course_id' => 'required|exists:courses,id', 
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
                'course_id' => $request->course_id,
                
            ]);
        }

        return redirect()->route('survey.complete')->with('success', 'Tus respuestas han sido guardadas correctamente');
    }

    public function submitSurvey(Request $request, $surveyId)
    {

        $courseId = session('course_id');

    // Si no existe, redirigir al login o mostrar un mensaje de error
    if (!$courseId) {
        return redirect()->route('login.form')->withErrors(['error' => 'No se pudo encontrar el curso asociado al aprendiz.']);
    }

    // Validación de las respuestas
    $data = $request->validate([
        'answers' => 'required|array',
        'answers.*' => 'required|string',
    ]);


        foreach ($request->answers as $instructorId => $questions) {
            foreach ($questions as $questionId => $answer) {
                Answer::create([
                    'apprentice_id' => null,
                    'instructor_id' => $instructorId,
                    'question_id' => $questionId,
                    'qualification' => is_array($answer) ? json_encode($answer) : $answer,
                    'course_id' => $courseId,  // Usar el `course_id` de la sesión
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
*/

/* 

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
        $survey = Survey::with('questions')->find($surveyId);
        $user = Auth::user();

    if (!$user->course) {
        abort(403, 'No estás inscrito en un curso válido.');
    }

    $instructors = $user->course->instructors;

    return view('survey.form', compact('survey', 'instructors'));
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

    public function index()
    {
        $_SURVEY= Survey::orderBy('id', 'desc' )
            ->paginate(2);
        return view('survey.form', compact('survey'));
    }

}
*/