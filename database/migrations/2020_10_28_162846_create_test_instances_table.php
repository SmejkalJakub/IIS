<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_instances', function (Blueprint $table) {
            $table->id();
            $table->timestamps();


            $table->integer('test_id');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');
            $table->integer('student_id');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('assistant_id');
            $table->foreign('assistant_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_instances');
    }
}
