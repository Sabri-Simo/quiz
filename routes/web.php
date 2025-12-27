<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return view("welcome");
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware("auth")->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit",
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update",
    );
    Route::delete("/profile", [ProfileController::class, "destroy"])->name(
        "profile.destroy",
    );
Route::get('/test-morocco', function() {
    $morocco = \App\Models\Country::where('code', 'MAR')->first();
    if (!$morocco) {
        return "Morocco not found";
    }
    
    return view('test', [
        'country' => $morocco,
        'difficulties' => $morocco->difficulties,
        'questions' => $morocco->difficulties->first()->questions ?? collect()
    ]);
});

    // Quiz Routes
    Route::get('/countries', [QuizController::class, 'countries'])->name('countries.index');
    Route::get('/country/{country}/difficulties', [QuizController::class, 'difficulties'])->name('country.difficulties');
    Route::get('/difficulty/{difficulty}/quiz', [QuizController::class, 'showQuiz'])->name('quiz.show');
    Route::post('/difficulty/{difficulty}/submit', [QuizController::class, 'submitQuiz'])->name('quiz.submit');
    Route::get('/results', [QuizController::class, 'results'])->name('quiz.results');
    Route::get('/results/{userScore}', [QuizController::class, 'resultDetails'])->name('quiz.result-details');
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');





    // Test route (optional - you can remove if not needed)
    Route::get("/quiz/{country}/{difficulty}", function (
        $country,
        $difficulty,
    ) {
        return "Quiz for $country - Difficulty: $difficulty";
    });
});

require __DIR__ . "/auth.php";