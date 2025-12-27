<?php

namespace App\Http\Controllers;

use App\Models\UserScore;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Initialize with default values
        $totalScore = 0;
        $completedQuizzes = 0;
        $recentScores = collect();

        // Check if UserScore model exists (tables might not be migrated yet)
        if (class_exists(UserScore::class)) {
            $totalScore =
                UserScore::where("user_id", $user->id)->sum("score") ?? 0;
            $completedQuizzes =
                UserScore::where("user_id", $user->id)->count() ?? 0;
            $recentScores = UserScore::with(["country", "difficulty"])
                ->where("user_id", $user->id)
                ->latest()
                ->take(5)
                ->get();
        }

        return view("dashboard", [
            "totalScore" => $totalScore,
            "completedQuizzes" => $completedQuizzes,
            "recentScores" => $recentScores,
        ]);
    }
}
