<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Difficulty extends Model
{
    use HasFactory;

    protected $fillable = ["country_id", "level", "points_per_question"];

    protected $casts = [
        "level" => "string",
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function userScores(): HasMany
    {
        return $this->hasMany(UserScore::class);
    }
}
