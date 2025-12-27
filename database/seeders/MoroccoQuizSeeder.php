<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Difficulty;
use App\Models\Question;
use App\Models\Choice;

class MoroccoQuizSeeder extends Seeder
{
    public function run(): void
    {
        // Create Morocco
        $morocco = Country::create([
            'name' => 'Morocco',
            'code' => 'MAR',
            'flag_emoji' => '🇲🇦'
        ]);

        // Difficulties
        $easy = Difficulty::create([
            'country_id' => $morocco->id,
            'level' => 'easy',
            'points_per_question' => 2
        ]);

        $medium = Difficulty::create([
            'country_id' => $morocco->id,
            'level' => 'medium',
            'points_per_question' => 2
        ]);

        $hard = Difficulty::create([
            'country_id' => $morocco->id,
            'level' => 'hard',
            'points_per_question' => 2
        ]);

        // EASY QUESTIONS
        $easyQuestions = [
            [
                'question_text' => 'What is the capital city of Morocco?',
                'explanation' => 'Rabat has been the capital since 1912.',
                'choices' => [
                    ['text' => 'Rabat', 'is_correct' => true],
                    ['text' => 'Casablanca', 'is_correct' => false],
                    ['text' => 'Marrakesh', 'is_correct' => false],
                ]
            ],
            [
                'question_text' => 'Which currency is used in Morocco?',
                'explanation' => 'The Moroccan Dirham is the official currency.',
                'choices' => [
                    ['text' => 'Moroccan Dirham', 'is_correct' => true],
                    ['text' => 'Moroccan Dinar', 'is_correct' => false],
                    ['text' => 'Moroccan Franc', 'is_correct' => false],
                ]
            ],
            [
                'question_text' => 'What colors are on the Moroccan flag?',
                'explanation' => 'The flag features a red field with a green pentagram.',
                'choices' => [
                    ['text' => 'Red and Green', 'is_correct' => true],
                    ['text' => 'Green and White', 'is_correct' => false],
                    ['text' => 'Red and Yellow', 'is_correct' => false],
                ]
            ],
            [
                'question_text' => 'Which languages are official in Morocco?',
                'explanation' => 'Arabic and Amazigh (Berber) are official languages.',
                'choices' => [
                    ['text' => 'Arabic', 'is_correct' => true],
                    ['text' => 'French', 'is_correct' => false],
                    ['text' => 'Berber (Tamazight)', 'is_correct' => true],
                ]
            ],
            [
                'question_text' => 'What is the largest city in Morocco?',
                'explanation' => 'Casablanca is the largest city and economic center.',
                'choices' => [
                    ['text' => 'Casablanca', 'is_correct' => true],
                    ['text' => 'Rabat', 'is_correct' => false],
                    ['text' => 'Fes', 'is_correct' => false],
                ]
            ],
        ];

        $this->createQuestions($easy, $easyQuestions);
        $this->createQuestions($medium, $this->mediumQuestions());
        $this->createQuestions($hard, $this->hardQuestions());
    }

    private function createQuestions($difficulty, array $questions)
    {
        foreach ($questions as $q) {
            $question = Question::create([
                'difficulty_id' => $difficulty->id,
                'question_text' => $q['question_text'],
                'explanation' => $q['explanation']
            ]);

            foreach ($q['choices'] as $choice) {
                Choice::create([
                    'question_id' => $question->id,
                    'choice_text' => $choice['text'],
                    'is_correct' => $choice['is_correct']
                ]);
            }
        }
    }

    private function mediumQuestions()
    {
        return [
            [
                'question_text' => 'Which mountain range runs through Morocco?',
                'explanation' => 'The Atlas Mountains run through Morocco.',
                'choices' => [
                    ['text' => 'Atlas Mountains', 'is_correct' => true],
                    ['text' => 'Himalayas', 'is_correct' => false],
                    ['text' => 'Andes', 'is_correct' => false],
                ]
            ],
            [
                'question_text' => 'When did Morocco gain independence?',
                'explanation' => 'Morocco gained independence in 1956.',
                'choices' => [
                    ['text' => '1956', 'is_correct' => true],
                    ['text' => '1962', 'is_correct' => false],
                    ['text' => '1945', 'is_correct' => false],
                ]
            ],
        ];
    }

    private function hardQuestions()
    {
        return [
            [
                'question_text' => 'Which dynasty founded Marrakesh?',
                'explanation' => 'The Almoravid dynasty founded Marrakesh.',
                'choices' => [
                    ['text' => 'Almoravid dynasty', 'is_correct' => true],
                    ['text' => 'Almohad dynasty', 'is_correct' => false],
                    ['text' => 'Saadi dynasty', 'is_correct' => false],
                ]
            ],
        ];
    }
}
