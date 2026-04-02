<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Questions\Models\Answer;
use Questions\Models\Question;
use Questions\Models\Tag;
use Users\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Демо Пользователь',
                'password' => Hash::make('demo1234'),
                'role' => 'user',
                'rating' => 10,
            ]
        );



        $math = Tag::firstOrCreate(['name' => 'математика'], ['color' => '#3498db']);
        $php = Tag::firstOrCreate(['name' => 'php'], ['color' => '#7777ff']);
        $algo = Tag::firstOrCreate(['name' => 'алгоритмы'], ['color' => '#2ecc71']);

        $q1 = Question::create([
            'title' => 'Как решить квадратное уравнение?',
            'content' => 'Нужно подробное объяснение формулы дискриминанта с примерами.',
            'author_id' => $user->id,
            'status' => 'published',
            'views' => 128,
            'likes' => 15,
        ]);
        $q1->tags()->attach([$math->id]);

        $q2 = Question::create([
            'title' => 'Разница между == и === в PHP',
            'content' => 'В каких случаях использовать строгое сравнение?',
            'author_id' => $user->id,
            'status' => 'published',
            'views' => 89,
            'likes' => 7,
        ]);
        $q2->tags()->attach([$php->id]);

        // Ответы
        Answer::create([
            'answer' => ['text' => 'Формула: x = (-b ± √D) / 2a, где D = b² - 4ac'],
            'author_id' => $user->id,
            'question_id' => $q1->id,
            'status' => 'published',
            'views' => 45,
            'likes' => 8,
        ]);

        Answer::create([
            'answer' => ['text' => '=== сравнивает и значение, и тип. == приводит типы перед сравнением.'],
            'author_id' => $user->id,
            'question_id' => $q2->id,
            'status' => 'published',
            'views' => 32,
            'likes' => 5,
        ]);

        // Вопрос на модерации (для теста)
        $draft = Question::create([
            'title' => 'Черновик: тема для будущего вопроса',
            'content' => 'Этот вопрос ещё не опубликован.',
            'author_id' => $user->id,
            'status' => 'on_moderate',
        ]);
        $draft->tags()->attach([$algo->id]);
    }
}
