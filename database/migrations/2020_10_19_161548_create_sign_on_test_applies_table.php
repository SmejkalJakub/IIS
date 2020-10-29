<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignOnTestAppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sign_on_test_applies', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->datetime('applied_datetime');
            $table->datetime('confirmed_datetime');

            $table->boolean('correction');


            $table->integer('applier_id');
            $table->foreign('applier_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('authorizer_id');
            $table->foreign('authorizer_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('test_id');
            $table->foreign('test_id')->references('id')->on('tests')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sign_on_test_applies');
    }
}
