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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained()->onDelete('cascade');

            //Item Title
            $table->json('title');
            $table->string('icon')->default('primary')->nullable();


            //Badge Options
            $table->string('badge_color')->nullable();
            $table->boolean('has_badge')->default(1)->nullable();
            $table->boolean('has_badge_query')->default(1)->nullable();
            $table->string('badge_table')->nullable();
            $table->string('badge_condation')->nullable();
            $table->json('badge')->nullable();

            //URL Options
            $table->boolean('is_route')->default(1)->nullable();
            $table->string('route')->nullable();
            $table->string('url')->nullable();
            $table->boolean('new_tab')->nullable();

            //Permissions
            $table->json('permissions')->nullable();
            $table->integer('order')->default(0)->nullable();
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
        Schema::dropIfExists('menu_items');
    }
};
