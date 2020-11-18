<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestInstanceQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_instance_questions', function (Blueprint $table) {
            $table->unique(['test_instance_id', 'question_id']);

            $table->timestamps();
            $table->string('answer')->nullable();
            $table->unsignedDouble('points')->nullable();

            $table->bigInteger('test_instance_id')->unsigned();
            $table->foreign('test_instance_id')->references('id')->on('test_instances')->onDelete('cascade');
            $table->bigInteger('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_instance_questions');
    }
}
