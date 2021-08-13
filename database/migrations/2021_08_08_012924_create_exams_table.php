<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();

            $table->integer('total_subject');
            $table->integer('questions_per_subject');
            $table->string('exam_Intruction');
            $table->string('exam_date');
            $table->string('student_delay');
            $table->boolean('randomize_questions');
            $table->boolean('randomize_answer');
            $table->boolean('exam_end_instruction');
            $table->string('year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams');
    }
}
