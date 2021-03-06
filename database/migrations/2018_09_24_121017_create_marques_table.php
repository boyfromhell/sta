<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarquesTable extends Migration
{
    public function up()
    {
        Schema::create('marques', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom')->unique();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('marques');
    }
}
