<?php

namespace Database\Seeders;

use App\Models\Survey;
use App\Models\Question;
use Illuminate\Database\Seeder;

class SurveySeeder extends Seeder
{
    public function run()
    {
        // Crear la encuesta
        $survey = Survey::create([
            'name' => 'Encuesta de Satisfacción del Curso',
            'description' => 'Esta encuesta tiene como objetivo recoger la opinión de los aprendices sobre la calidad del curso y los instructores.',
        ]);

        // Crear las preguntas asociadas
        Question::create([
            'survey_id' => $survey->id,
            'question' => '¿Cómo calificarías la calidad general del curso?',
            'type' => 'radio',
            'options' => ['1', '2', '3', '4', '5'],
        ]);

        Question::create([
            'survey_id' => $survey->id,
            'question' => '¿El instructor explicó los temas de manera clara?',
            'type' => 'radio',
            'options' => ['1', '2', '3', '4', '5'],
        ]);

        Question::create([
            'survey_id' => $survey->id,
            'question' => '¿El material del curso fue adecuado para aprender?',
            'type' => 'radio',
            'options' => ['1', '2', '3', '4', '5'],
        ]);

        Question::create([
            'survey_id' => $survey->id,
            'question' => '¿Recomendarías este curso a otros aprendices?',
            'type' => 'radio',
            'options' => ['Sí', 'No'],
        ]);

        Question::create([
            'survey_id' => $survey->id,
            'question' => '¿Qué sugerencias tienes para mejorar el curso?',
            'type' => 'text',
            'options' => null,
        ]);
    }
}