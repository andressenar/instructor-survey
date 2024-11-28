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
    public function courses()
    {
        $courses = Course::included()->get();
        return view('reports.courses', compact('courses'));
    }
    public function index()
    {
        $questions = Question::included()->get();
        return view('reports.index', compact('questions'));
    }
    public function show($courseId, $instructorId, $programId)
    {
        $answers = Answer::whereHas('instructor.courses', function ($query) use ($courseId, $programId) {
            $query->where('courses.id', $courseId)
                ->where('courses.program_id', $programId);
        })->where('instructor_id', $instructorId)->get();
        $reportData = $answers->groupBy('question_id')->map(function ($group) {
            $calificaciones = $group->pluck('qualification')->map(function ($value) {
                return (int)$value; 
            });
            return [
                'average' => $calificaciones->avg(),
                'count' => $group->count(),
            ];
        });
        $questions = Question::whereIn('id', $reportData->keys())->pluck('question', 'id');

        return view('reports.show', [
            'reportData' => $reportData,
            'questions' => $questions,
            'instructor' => Instructor::find($instructorId),
            'course' => Course::find($courseId),
            'program' => Program::find($programId)
        ]);
    }
}
