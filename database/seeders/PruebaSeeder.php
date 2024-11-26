<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Para usar DB en inserciones directas
use Illuminate\Support\Str; // Para generar strings aleatorios
use Faker\Factory as Faker;;

class PruebaSeeder extends Seeder
    {
        public function run()
    {
        $faker = Faker::create();

        // 1. Llenar la tabla 'programs'
        $programs = [];
        for ($i = 0; $i <= 20; $i++) {
            $programs[] = DB::table('programs')->insertGetId([
                'code' => strtoupper($faker->bothify('PROG-###')),
                'name' => $faker->sentence(3),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Llenar la tabla 'municipalities'
        $municipalities = [];
        for ($i = 0; $i <=5; $i++) {
            $municipalities[] = DB::table('municipalities')->insertGetId([
                'name' => $faker->city,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Llenar la tabla 'courses'
        $courses = [];
        for ($i = 0; $i <=10; $i++) {
            $courses[] = DB::table('courses')->insertGetId([
                'code' => strtoupper($faker->bothify('COURSE-###')),
                'program_id' => $faker->randomElement($programs),
                'municipality_id' => $faker->randomElement($municipalities),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 4. Llenar la tabla 'users'
        $users = [];
        for ($i = 0; $i <=40; $i++) {
            $users[] = DB::table('users')->insertGetId([
                'identity_document' => $faker->unique()->numerify('########'),
                'first_name' => $faker->firstName,
                'middle_name' => $faker->optional()->firstName,
                'last_name' => $faker->lastName,
                'second_last_name' => $faker->optional()->lastName,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => $faker->optional()->dateTime,
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 5. Llenar la tabla 'apprentices'
        $apprentices = [];
        foreach (array_slice($users, 0, 30) as $userId) {
            $apprentices[] = DB::table('apprentices')->insertGetId([
                'user_id' => $userId,
                'course_id' => $faker->randomElement($courses),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 6. Llenar la tabla 'instructors'
        $instructors = [];
        foreach (array_slice($users, 10, 10) as $userId) {
            $instructors[] = DB::table('instructors')->insertGetId([
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 7. Llenar la tabla 'surveys'
        $surveys = [];
        for ($i = 0; $i <=5; $i++) {
            $surveys[] = DB::table('surveys')->insertGetId([
                'name' => $faker->sentence(3),
                'description' => $faker->paragraph,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 8. Llenar la tabla 'questions'
        $questions = [];
        foreach ($surveys as $surveyId) {
            for ($i = 0; $i <=5; $i++) {
                $questions[] = DB::table('questions')->insertGetId([
                    'type' => $faker->randomElement(['text', 'choice', 'rating']),
                    'question' => $faker->sentence,
                    'survey_id' => $surveyId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 9. Llenar la tabla 'answers'
        foreach ($apprentices as $apprenticeId) {
            foreach ($questions as $questionId) {
                DB::table('answers')->insert([
                    'type' => $faker->randomElement(['text', 'choice', 'rating']),
                    'qualification' => $faker->randomElement(['Good', 'Average', 'Bad']),
                    'apprentice_id' => $apprenticeId,
                    'instructor_id' => $faker->randomElement($instructors),
                    'question_id' => $questionId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 10. Llenar la tabla 'course_instructor'
        foreach ($instructors as $instructorId) {
            DB::table('course_instructor')->insert([
                'instructor_id' => $instructorId,
                'course_id' => $faker->randomElement($courses),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    } // datos
