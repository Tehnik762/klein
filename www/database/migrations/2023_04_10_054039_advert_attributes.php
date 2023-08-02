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
        Schema::create('advert_attributes', function (Blueprint $table) {
            $table->id();
            $table->integer('advert_category_id')->references('id')->on('advert_categories')->onDelete('CASCADE');
            $table->string('name');
            $table->string('type');
            $table->boolean('required')->nullable();
            $table->json('variants')->nullable();
            $table->integer('sort');
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
        Schema::dropIfExists('advert_attributes');
    }
};
