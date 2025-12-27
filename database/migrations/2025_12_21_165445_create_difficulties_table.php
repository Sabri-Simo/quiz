<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("difficulties", function (Blueprint $table) {
            $table->id();
            $table->foreignId("country_id")->constrained()->onDelete("cascade");
            $table->enum("level", ["easy", "medium", "hard"]);
            $table->integer("points_per_question")->default(2);
            $table->timestamps();

            $table->unique(["country_id", "level"]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("difficulties");
    }
};
