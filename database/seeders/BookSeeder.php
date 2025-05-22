<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'title' => 'Harry Potter and the Philosopher\'s Stone',
            'description' => 'A young man discovers he is a wizard and attends a magical school.',
            'price' => 80000,
            'stock' => 100,
            'cover_photo' => 'https://example.com/harry_potter.jpg',
            'genre_id' => 1,
            'author_id' => 1,
        ]);
        Book::create([
            'title' => 'The Hobbit',
            'description' => 'A hobbit embarks on an unexpected journey with a group of dwarves.',
            'price' => 60000,
            'stock' => 50,
            'cover_photo' => 'https://example.com/the_hobbit.jpg',
            'genre_id' => 2,
            'author_id' => 2,
        ]);
        Book::create([
            'title' => 'To Kill a Mockingbird',
            'description' => 'A novel about the serious issues of defending a birdon and racial inequality.',
            'price' => 70000,
            'stock' => 30,
            'cover_photo' => 'https://example.com/to_kill_a_mockingbird.jpg',
            'genre_id' => 3,
            'author_id' => 3,
        ]);
        Book::create([
            'title' => '1984',
            'description' => 'A dystopian novel set in a totalitarian society under constant surveillance.',
            'price' => 75000,
            'stock' => 20,
            'cover_photo' => 'https://example.com/1984.jpg',
            'genre_id' => 4,
            'author_id' => 4,
        ]);
        Book::create([
            'title' => 'Pride and Prejudice',
            'description' => 'A romantic novel that explores the themes of love and social class.',
            'price' => 65000,
            'stock' => 40,
            'cover_photo' => 'https://example.com/pride_and_prejudice.jpg',
            'genre_id' => 5,
            'author_id' => 5,
        ]);
    }
}
