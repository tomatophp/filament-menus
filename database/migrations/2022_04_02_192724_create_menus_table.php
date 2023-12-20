<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();

            //Set Key To Get Menu
            $table->string('key')->unique();

            //Where You Can See The Menu
            $table->string('location')->default('header');

            //Title For The Menu
            $table->string('title');

            //Menu Item As Json
            $table->longText('items')->nullable();

            //Are Menu Is Active?
            $table->boolean('activated')->default(0);
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
        Schema::dropIfExists('menus');
    }
};
