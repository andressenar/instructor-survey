<?php

namespace App\Http\Controllers;

use App\Models\Apprentice;
use App\Models\Course; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'course_code' => 'required|exists:courses,code', 
            'identity_document' => 'required|exists:apprentices,identity_document', 
        ]);

        // Obtener el curso correspondiente al código proporcionado
        $course = Course::where('code', $request->course_code)->first();

        if ($course) {
            // Intentar obtener al aprendiz con la cédula indicada y que esté asociado al curso encontrado
            $apprentice = Apprentice::where('course_id', $course->id)
                ->where('identity_document', $request->identity_document)
                ->first();

            if ($apprentice) {
                Auth::login($apprentice);
                return redirect()->route('survey.show', ['apprenticeId' => $apprentice->id, 'surveyId' => 1]);
            }
        }

        // Si no se encontró el aprendiz o el curso, redirigir con error
        return back()->withErrors(['error' => 'Curso o número de identificación incorrectos.']);
    }

    // Cerrar sesión
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }
}
