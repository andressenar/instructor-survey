<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Program;
use App\Models\Question;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function admin()
    {
        return view('admin.admin');
    }

    public function index()
    {
        $instructors = Instructor::with(['courses.program'])->get();
        return view('reports.index', compact('instructors'));
    }
    public function show($courseId, $instructorId, $programId)
    {
        $answers = Answer::whereHas('instructor.courses', function ($query) use ($courseId, $programId) {
            $query->where('courses.id', $courseId)
                ->where('courses.program_id', $programId);
        })->where('instructor_id', $instructorId)->get();
        $reportData = $answers->where('question_id', '<', 21)->groupBy('question_id')->map(function ($group) {
            $calificaciones = $group->pluck('qualification')->map(fn($value) => (int)$value);
            return [
                'average' => $calificaciones->avg(),
                'count' => $group->count(),
            ];
        });
        $observations = $answers->whereIn('question_id', [21, 22])->map(fn($answer) => $answer->text);
        $questions = Question::whereIn('id', $reportData->keys())->pluck('question', 'id');

        return view('reports.show', [
            'reportData' => $reportData,
            'questions' => $questions,
            'observations' => $observations,
            'instructor' => Instructor::find($instructorId),
            'course' => Course::find($courseId),
            'program' => Program::find($programId)
        ]);
    }
    public function showGeneral($instructorId)
    {
        // Obtener todas las respuestas asociadas al instructor sin filtrar por curso ni programa
        $answers = Answer::where('instructor_id', $instructorId)->get();
        // Agrupar las respuestas por pregunta y calcular promedio y cantidad de respuestas
        $reportData = $answers->groupBy('question_id')->map(function ($group) {
            $calificaciones = $group->pluck('qualification')->map(function ($value) {
                return (int)$value;
            });
            return [
                'average' => $calificaciones->avg(),
                'count' => $group->count(),
            ];
        });

        // Obtener el texto de las preguntas
        $questions = Question::whereIn('id', $reportData->keys())->pluck('question', 'id');

        // Retornar la vista con los datos del reporte
        return view('reports.general', [
            'reportData' => $reportData,
            'questions' => $questions,
            'instructor' => Instructor::find($instructorId)
        ]);
    }
}
