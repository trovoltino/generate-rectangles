<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRectanglesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rectangle_entity', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->string('rectangle_id');
            $table->string('png_id');
            $table->integer('position_x');
            $table->integer('position_y');
            $table->integer('height');
            $table->integer('width');
            $table->char('color_code_hex', 10);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rectangle_entity');
    }
}
