<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePngsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('png_entity', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('request_id')->unique();
            $table->char('color_code_hex', 10);
            $table->integer('height');
            $table->integer('width');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('png_entity');
    }
}
