<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::create([
            'name' => 'J.K. Rowling',
            'description' => 'J.K. Rowling adalah penulis asal Inggris yang terkenal dengan seri buku Harry Potter.',
            'photo' => 'https://example.com/jk_rowling.jpg',
        ]);
        Author::create([
            'name' => 'Stephen King',
            'description' => 'Stephen King adalah penulis asal Amerika Serikat yang terkenal dengan novel-novel horor dan thriller.',
            'photo' => 'https://example.com/stephen_king.jpg',
        ]);
        Author::create([
            'name' => 'Agatha Christie',
            'description' => 'Agatha Christie adalah penulis asal Inggris yang terkenal dengan novel-novel misteri.',
            'photo' => 'https://example.com/agatha_christie.jpg',
        ]);
        Author::create([
            'name' => 'George R.R. Martin',
            'description' => 'George R.R. Martin adalah penulis asal Amerika Serikat yang terkenal dengan seri novel A Song of Ice and Fire.',
            'photo' => 'https://example.com/george_rr_martin.jpg',
        ]);
        Author::create([
            'name' => 'J.R.R. Tolkien',
            'description' => 'J.R.R. Tolkien adalah penulis asal Inggris yang terkenal dengan novel The Lord of the Rings.',
            'photo' => 'https://example.com/jrr_tolkien.jpg',
        ]);
    }
}
