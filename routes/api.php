<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Definición de las rutas de la API
Route::get('/saludo', function () {
    return response()->json(['mensaje' => 'Hola desde la API']);
});

// Ejemplo de ruta que usa un controlador
Route::get('/productos', [App\Http\Controllers\ProductoController::class, 'index']);