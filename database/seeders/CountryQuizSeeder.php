<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Difficulty;
use App\Models\Question;
use App\Models\Choice;
use Illuminate\Database\Seeder;

class CountryQuizSeeder extends Seeder
{
    public function run(): void
    {
        // Create countries
        $countries = [
            ['name' => 'United States', 'code' => 'USA', 'flag_emoji' => '🇺🇸'],
            ['name' => 'France', 'code' => 'FRA', 'flag_emoji' => '🇫🇷'],
            ['name' => 'Japan', 'code' => 'JPN', 'flag_emoji' => '🇯🇵'],
            ['name' => 'Brazil', 'code' => 'BRA', 'flag_emoji' => '🇧🇷'],
            ['name' => 'Egypt', 'code' => 'EGY', 'flag_emoji' => '🇪🇬'],
        ];

        foreach ($countries as $countryData) {
            $country = Country::create($countryData);

            // Create 3 difficulty levels for each country
            $levels = ['easy', 'medium', 'hard'];
            
            foreach ($levels as $level) {
                $difficulty = Difficulty::create([
                    'country_id' => $country->id,
                    'level' => $level,
                    'points_per_question' => $level === 'easy' ? 2 : ($level === 'medium' ? 3 : 4)
                ]);

                // Create 5 questions for each difficulty level
                for ($i = 1; $i <= 5; $i++) {
                    $question = Question::create([
                        'difficulty_id' => $difficulty->id,
                        'question_text' => "Question $i about {$country->name} ({$level})",
                        'explanation' => "Explanation for question $i"
                    ]);

                    // Create 3 choices for each question
                    // Randomly decide if 1 or 2 choices are correct
                    $correctCount = rand(1, 2);
                    $correctIndices = array_rand([0, 1, 2], $correctCount);
                    
                    if (!is_array($correctIndices)) {
                        $correctIndices = [$correctIndices];
                    }

                    for ($j = 0; $j < 3; $j++) {
                        Choice::create([
                            'question_id' => $question->id,
                            'choice_text' => "Choice " . ($j + 1) . " for question $i",
                            'is_correct' => in_array($j, $correctIndices)
                        ]);
                    }
                }
            }
        }
    }
}