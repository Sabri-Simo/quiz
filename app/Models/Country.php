<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ["name", "code", "flag_emoji"];

    public function difficulties(): HasMany
    {
        return $this->hasMany(Difficulty::class);
    }

    public function userScores(): HasMany
    {
        return $this->hasMany(UserScore::class);
    }
}
