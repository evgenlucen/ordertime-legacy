<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebinarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webinars', function (Blueprint $table) {
            $table->string('_id');
            $table->string('name');
            $table->string('text');
            $table->string('type');
            $table->integer('nerrors');
            $table->integer('count1');
            $table->integer('count2');
            $table->json('data');
            $table->string('webinarId')->primary();
            $table->string('mode')->nullable();
            $table->dateTime('created');
            $table->boolean('send_to_amo')->default(false);
            $table->integer('time_start')->nullable();
            $table->integer('time_end')->nullable();

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
        Schema::dropIfExists('webinars');
    }
}
