<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genre::create([
            'name' => 'Fiksi',
            'description' => 'Genre fiksi adalah genre yang berisi cerita-cerita yang tidak berdasarkan pada fakta atau kenyataan.',
        ]);

        Genre::create([
            'name' => 'Non-Fiksi',
            'description' => 'Genre non-fiksi adalah genre yang berisi cerita-cerita yang berdasarkan pada fakta atau kenyataan.',
        ]);

        Genre::create([
            'name' => 'Fantasi',
            'description' => 'Genre fantasi adalah genre yang berisi cerita-cerita yang mengandung unsur-unsur magis atau supernatural.',
        ]);
    }
}
