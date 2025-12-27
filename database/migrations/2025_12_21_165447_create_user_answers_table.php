<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("user_answers", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table
                ->foreignId("question_id")
                ->constrained()
                ->onDelete("cascade");
            $table
                ->foreignId("choice_id")
                ->nullable()
                ->constrained()
                ->onDelete("cascade");
            $table->boolean("is_correct")->default(false);
            $table->integer("points_earned")->default(0);
            $table->timestamps();

            $table->unique(["user_id", "question_id"]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("user_answers");
    }
};
