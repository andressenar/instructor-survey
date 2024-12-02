<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();

            $table->string('type')->default('default_value');
            $table->string('qualification');

            $table->unsignedBigInteger('apprentice_id')->nullable(); // Esto permite que apprentice_id sea null
            $table->foreign('apprentice_id')->references('id')->on('apprentices')->onDelete('set null');
/* 
    $table->unsignedBigInteger('course_id');  
    $table->foreign('course_id')->references('id')->on('courses'); */


            $table->unsignedBigInteger('instructor_id');
            $table->foreign('instructor_id')->references('id')->on('instructors');

            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('questions');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
