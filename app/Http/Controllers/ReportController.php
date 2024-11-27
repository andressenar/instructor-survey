<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Muestra la vista de selección de cursos y maestros
    public function index()
    {
        $courses = Course::with('instructors')->get();
        return view('reports.index', compact('courses'));
    }

    // Muestra el reporte de respuestas por maestro
    public function show($courseId, $instructorId)
    {

        // Filtrar respuestas por curso e instructor con relación muchos a muchos
        $answers = Answer::whereHas('instructor.courses', function ($query) use ($courseId) {
            $query->where('courses.id', $courseId); // Especificamos el prefijo 'courses.id' para evitar ambigüedad
        })->where('instructor_id', $instructorId)->get();

        // Agrupar calificaciones por pregunta
        $reportData = $answers->groupBy('question_id')->map(function ($answers) {
            return $answers->avg('qualification'); // Calificación promedio
        });

        // Obtener etiquetas de preguntas
        $questions = $answers->map->question->unique('id')->pluck('text');

        return view('reports.show', [
            'reportData' => $reportData,
            'questions' => $questions,
            'instructor' => Instructor::find($instructorId),
            'course' => Course::find($courseId)
        ]);
    }
}
