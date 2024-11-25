<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    public function run()
    {
        // Lista de programas del SENA con su respectivo código y nombre
        $programas = [
            ['code' => 'SEN001', 'name' => 'Técnico en Sistemas'],
            ['code' => 'SEN002', 'name' => 'Técnico en Mecánica Automotriz'],
            ['code' => 'SEN003', 'name' => 'Técnico en Diseño Gráfico'],
            ['code' => 'SEN004', 'name' => 'Tecnólogo en Gestión de Empresas'],
            ['code' => 'SEN005', 'name' => 'Tecnólogo en Análisis y Desarrollo de Software'],
            ['code' => 'SEN006', 'name' => 'Técnico en Salud Oral'],
            ['code' => 'SEN007', 'name' => 'Técnico en Contabilidad y Finanzas'],
            ['code' => 'SEN008', 'name' => 'Técnico en Electricidad'],
            ['code' => 'SEN009', 'name' => 'Tecnólogo en Gestión de Mercados'],
            ['code' => 'SEN010', 'name' => 'Técnico en Auxiliar Administrativo'],
            ['code' => 'SEN011', 'name' => 'Técnico en Cocina'],
            ['code' => 'SEN012', 'name' => 'Tecnólogo en Producción de Medios Audiovisuales'],
            ['code' => 'SEN013', 'name' => 'Técnico en Desarrollo de Software'],
            ['code' => 'SEN014', 'name' => 'Técnico en Logística'],
            ['code' => 'SEN015', 'name' => 'Técnico en Seguridad y Salud en el Trabajo'],
            ['code' => 'SEN016', 'name' => 'Tecnólogo en Gestión de la Información'],
            ['code' => 'SEN017', 'name' => 'Técnico en Moda'],
            ['code' => 'SEN018', 'name' => 'Técnico en Agricultura'],
            ['code' => 'SEN019', 'name' => 'Técnico en Energías Renovables'],
            ['code' => 'SEN020', 'name' => 'Técnico en Carreteras y Vías'],
            ['code' => 'SEN021', 'name' => 'Tecnólogo en Seguridad Industrial'],
            ['code' => 'SEN022', 'name' => 'Técnico en Producción de Audio'],
            ['code' => 'SEN023', 'name' => 'Técnico en Asistencia Administrativa'],
            ['code' => 'SEN024', 'name' => 'Técnico en Turismo'],
            ['code' => 'SEN025', 'name' => 'Tecnólogo en Gestión Logística'],
            ['code' => 'SEN026', 'name' => 'Técnico en Redes de Computadores'],
            ['code' => 'SEN027', 'name' => 'Tecnólogo en Desarrollo de Videojuegos'],
            ['code' => 'SEN028', 'name' => 'Técnico en Comercio Exterior'],
            ['code' => 'SEN029', 'name' => 'Técnico en Electricidad Industrial'],
            ['code' => 'SEN030', 'name' => 'Técnico en Instrumentación y Control'],
        ];

        // Insertar en la tabla 'programs' con 'code' y 'name'
        DB::table('programs')->insert($programas);
    }
}
