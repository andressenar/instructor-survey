<?php

namespace App\Http\Controllers;

use App\Models\Apprentice;
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
            'course_id' => 'required|exists:apprentices,course_id',  // Verificar que el course_id exista
            'identity_document' => 'required|exists:apprentices,identity_document',  // Verificar que el número de identificación exista
        ]);

        // Intentar obtener al aprendiz según course_id e identity_document
        $apprentice = Apprentice::where('course_id', $request->course_id)
            ->where('identity_document', $request->identity_document)
            ->first();

        // Si el aprendiz existe, autenticarlo
        if ($apprentice) {
            Auth::login($apprentice);  // Usamos el sistema de autenticación de Laravel
            return redirect()->route('survey.show', ['apprenticeId' => $apprentice->id, 'surveyId' => 1]); // Redirigir a la encuesta
        }

        // Si no se encuentra el aprendiz, devolver error
        return back()->withErrors(['error' => 'Curso o número de identificación incorrectos']);
    }

    // Cerrar sesión
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.form');
    }
}
