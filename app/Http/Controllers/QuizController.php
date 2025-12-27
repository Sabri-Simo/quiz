<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Difficulty;
use App\Models\Question;
use App\Models\Choice;
use App\Models\UserAnswer;
use App\Models\UserScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
class QuizController extends Controller
{
    public function countries()
    {
        $countries = Country::with(['difficulties.userScores' => function($query) {
            $query->where('user_id', auth()->id());
        }])->get();

        return view('quiz.countries', compact('countries'));
    }

    public function difficulties(Country $country)
    {
        $difficulties = $country->difficulties()->with(['userScores' => function($query) {
            $query->where('user_id', auth()->id());
        }])->get();

        return view('quiz.difficulties', compact('country', 'difficulties'));
    }

    public function showQuiz(Difficulty $difficulty)
    {
        $questions = $difficulty->questions()
            ->with(['choices'])
            ->inRandomOrder()
            ->limit(5) // Show 5 questions per quiz
            ->get();

        return view('quiz.show', compact('difficulty', 'questions'));
    }

public function submitQuiz(Request $request, Difficulty $difficulty)
{
    // Debug: log what we're receiving
    Log::info('=== QUIZ SUBMISSION START ===');
    Log::info('User ID: ' . auth()->id());
    Log::info('Difficulty ID: ' . $difficulty->id);
    Log::info('Answers received:', $request->all());
    
    try {
        // Validate
        $request->validate([
            'answers' => 'required|array',
        ]);
        
        $user = auth()->user();
        
        // Get all questions for this difficulty
        $questions = Question::with('choices')
            ->where('difficulty_id', $difficulty->id)
            ->get();
        
        Log::info('Found ' . $questions->count() . ' questions for this difficulty');
        
        $totalScore = 0;
        $correctAnswers = 0;
        $totalQuestions = $questions->count();
        
        // Process each question
        foreach ($questions as $question) {
            $questionId = $question->id;
            $selectedChoices = $request->input("answers.{$questionId}", []);
            
            Log::info("Processing question {$questionId}", [
                'selected' => $selectedChoices,
                'question_text' => $question->question_text
            ]);
            
            // Get correct choice IDs for this question
            $correctChoiceIds = $question->choices
                ->where('is_correct', true)
                ->pluck('id')
                ->toArray();
            
            Log::info("Correct choices for question {$questionId}:", $correctChoiceIds);
            
            // Check if answer is correct
            $isCorrect = false;
            $points = 0;
            
            if (!empty($selectedChoices)) {
                // Sort arrays for comparison
                sort($selectedChoices);
                sort($correctChoiceIds);
                
                // Check if selected choices match correct choices exactly
                if ($selectedChoices == $correctChoiceIds) {
                    $isCorrect = true;
                    $points = $difficulty->points_per_question;
                    $correctAnswers++;
                    Log::info("Question {$questionId}: CORRECT (+{$points} points)");
                } else {
                    $points = -2;
                    Log::info("Question {$questionId}: WRONG (-2 points)");
                }
            } else {
                Log::info("Question {$questionId}: NO ANSWER (0 points)");
            }
            
            $totalScore += $points;
            
            // Save user answer(s)
            if (empty($selectedChoices)) {
                // Save one record for unanswered question
                UserAnswer::create([
                    'user_id' => $user->id,
                    'question_id' => $questionId,
                    'choice_id' => null,
                    'is_correct' => false,
                    'points_earned' => 0,
                ]);
            } else {
                // Save one record per selected choice
                foreach ($selectedChoices as $choiceId) {
                    UserAnswer::create([
                        'user_id' => $user->id,
                        'question_id' => $questionId,
                        'choice_id' => $choiceId,
                        'is_correct' => $isCorrect,
                        'points_earned' => $points,
                    ]);
                }
            }
        }
        
        Log::info("Quiz completed. Total score: {$totalScore}, Correct: {$correctAnswers}/{$totalQuestions}");
        
        // Create user score record
        $userScore = UserScore::create([
            'user_id' => $user->id,
            'country_id' => $difficulty->country_id,
            'difficulty_id' => $difficulty->id,
            'score' => $totalScore,
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'incorrect_answers' => $totalQuestions - $correctAnswers,
            'completed_at' => now(),
        ]);
        
        Log::info('UserScore created with ID: ' . $userScore->id);
        Log::info('=== QUIZ SUBMISSION END ===');
        
        return redirect()->route('quiz.result-details', $userScore)
            ->with('success', 'Quiz submitted successfully! Your score: ' . $totalScore);
            
    } catch (\Exception $e) {
        Log::error('QUIZ SUBMISSION ERROR: ' . $e->getMessage());
        Log::error($e->getTraceAsString());
        
        return back()->with('error', 'Error submitting quiz: ' . $e->getMessage())
                     ->withInput();
    }
}
public function results()
{
    $userScores = UserScore::with(['country', 'difficulty'])
        ->where('user_id', auth()->id())
        ->latest()
        ->paginate(10);

    return view('quiz.results', compact('userScores'));
}

public function resultDetails(UserScore $userScore)
{
    if ($userScore->user_id !== auth()->id()) {
        abort(403);
    }

    $userAnswers = UserAnswer::with(['question.choices', 'choice'])
        ->where('user_id', auth()->id())
        ->whereIn('question_id', function($query) use ($userScore) {
            $query->select('id')
                  ->from('questions')
                  ->where('difficulty_id', $userScore->difficulty_id);
        })
        ->get();

    return view('quiz.result-details', compact('userScore', 'userAnswers'));
}
    
}