<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Instructor;
use App\Models\Apprentice;
use App\Models\Course;
use Illuminate\Support\Facades\Log;  // Asegúrate de importar el Log

class ImportController extends Controller
{
    public function import(Request $request)
    {
        // Validar que el archivo es un archivo de Excel
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Obtener la ruta del archivo subido
        $path = $request->file('file')->getRealPath();

        // Cargar el archivo Excel
        try {
            $spreadsheet = IOFactory::load($path);
        } catch (\Exception $e) {
            Log::error('Error al cargar el archivo Excel: ' . $e->getMessage());
            return back()->withErrors(['file' => 'Error al cargar el archivo Excel.']);
        }

        // Obtener los datos de las hojas y omitir la primera fila (encabezado)
        $sheetInstructors = array_slice($spreadsheet->getSheetByName('Instructores')->toArray(), 1);
        $sheetApprentices = array_slice($spreadsheet->getSheetByName('Aprendices')->toArray(), 1);
        $sheetCourses = array_slice($spreadsheet->getSheetByName('fichas')->toArray(), 1);

        // Importar fichas
        $courses = [];
        foreach ($sheetCourses as $row) {
            // Verificar que la fila tiene los datos necesarios
            if (!empty($row[0]) && !empty($row[1]) && !empty($row[2])) {
                $courses[] = Course::create([
                    'code' => $row[0],
                    'program_id' => $row[1],
                    'municipality_id' => $row[2],
                ]);
            } else {
                Log::warning('Fila de curso vacía o incompleta: ' . json_encode($row));
            }
        }

        // Importar Instructores
        foreach ($sheetInstructors as $row) {
            // Verificar que la fila tenga todos los datos necesarios
            if (!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4])) {
                Log::info('Creando o actualizando instructor: ' . $row[0] . ' ' . $row[1] . ' ' . $row[2]);

                // Usar updateOrCreate para evitar duplicados de identidad
                $instructor = Instructor::updateOrCreate(
                    ['identity_document' => $row[4]],
                    [
                        'first_name' => $row[0],
                        'middle_name' => $row[1],
                        'last_name' => $row[2],
                        'second_last_name' => $row[3],
                        'user_id' => 1,
                    ]
                );

                // Asociar los cursos al instructor
                $courseIds = explode(',', $row[5]);
                $instructor->courses()->syncWithoutDetaching($courseIds); 
            } else {
                Log::warning('Fila de instructor vacía o incompleta: ' . json_encode($row));
            }
        }

        // Importar Aprendices
        foreach ($sheetApprentices as $row) {
            // Verificar que la fila tenga todos los datos necesarios
            if (!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4])) {
                // Buscar el curso por código
                $course = Course::where('code', $row[5])->first();
                if ($course) {
                    $apprentice = Apprentice::create([
                        'first_name' => $row[0],
                        'middle_name' => $row[1],
                        'last_name' => $row[2],
                        'second_last_name' => $row[3],
                        'identity_document' => $row[4],
                        'user_id' => 2,
                        'course_id' => $course->id,
                    ]);
                } else {
                    Log::warning('Curso no encontrado para el código: ' . $row[5]);
                }
            } else {
                Log::warning('Fila de aprendiz vacía o incompleta: ' . json_encode($row));
            }
        }

        // Si llegamos hasta aquí, es que todo salió bien
        return back()->with('success', 'Datos importados correctamente');
    }
}
