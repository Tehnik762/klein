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
        Schema::create('adverts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('category_id')->references('id')->on('advert_categories')->onDelete('CASCADE');
            $table->integer('region_id')->nullable()->references('id')->on('regions')->onDelete('CASCADE');
            $table->string('title');
            $table->string('slug');
            $table->integer('price');
            $table->text('address');
            $table->text('content');
            $table->integer('status');
            $table->text('reject_reason')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    
        Schema::create('advert_attributes_values', function (Blueprint $table) {
            $table->id();
            $table->integer('attribute_id')->references('id')->on('attributes')->onDelete('CASCADE');
            $table->integer('advert_id')->references('id')->on('adverts')->onDelete('CASCADE');
            $table->string('value');
            $table->timestamps();
        });

        Schema::create('advert_photos', function (Blueprint $table) {
            $table->id();
            $table->integer('advert_id')->references('id')->on('adverts')->onDelete('CASCADE');
            $table->string('file');
            $table->string('storage_path');
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
        Schema::dropIfExists('adverts');
        Schema::dropIfExists('advert_attributes_values');
        Schema::dropIfExists('advert_photos');
    }
};
