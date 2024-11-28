<?php

// namespace Database\Seeders;

// use App\Models\User;
// use Illuminate\Database\Seeder;

// class DatabaseSeeder extends Seeder
// {

<<<<<<< HEAD
//     public function run(): void
//     {


//         User::factory()->create([
//             'name' => 'Test User',
//             'email' => 'test@example.com',
//         ]);
//     }
// }
=======
        $this->call([MunicipalitySeeder::class, SurveySeeder::class]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
>>>>>>> 823d9be2625c3e6cc038acca0aa506a82cf72489
