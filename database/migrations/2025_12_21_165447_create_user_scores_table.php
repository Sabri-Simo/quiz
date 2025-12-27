<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("user_scores", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->foreignId("country_id")->constrained()->onDelete("cascade");
            $table
                ->foreignId("difficulty_id")
                ->constrained()
                ->onDelete("cascade");
            $table->integer("score")->default(0);
            $table->integer("total_questions")->default(0);
            $table->integer("correct_answers")->default(0);
            $table->integer("incorrect_answers")->default(0);
            $table->timestamp("completed_at")->nullable();
            $table->timestamps();

            $table->unique(["user_id", "country_id", "difficulty_id"]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("user_scores");
    }
};
