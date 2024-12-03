<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\SurveyController;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('import');
});

Route::post('import', [ImportController::class, 'import'])->name('import');

// Rutas de autenticación

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware('auth')->group(function () {
<<<<<<< HEAD
=======
    Route::get('/admin', function () {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('survey.show', ['apprenticeId' => Auth::user()->id, 'surveyId' => 1]);
        }
        return view('admin.admin');
    })->name('admin');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{courseId}/{instructorId}/{programId}', [ReportController::class, 'show'])->name('reports.show');
    Route::post('/import', [ImportController::class, 'import'])->name('import');
    Route::get('reports/general/{instructorId}', [ReportController::class, 'showGeneral'])->name('reports.general');

>>>>>>> 9598d53 (new2)
    Route::get('/survey/{apprenticeId}/{surveyId}', [SurveyController::class, 'showSurvey'])->name('survey.show');
    Route::post('/survey/{surveyId}/submit', [SurveyController::class, 'storeAnswers'])->name('survey.submit');
    Route::get('/survey/complete', [SurveyController::class, 'complete'])->name('survey.complete');

    // Nueva ruta para mostrar detalles de una encuesta
    Route::get('/posts/{id}', [SurveyController::class, 'show'])->name('posts.show');
});
