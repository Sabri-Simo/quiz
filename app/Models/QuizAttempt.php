<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;
    protected $fillable = ["user_id", "country_id", "difficulty", "score"];

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }
}
