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
        Schema::create('favorites_advert', function (Blueprint $table) {
            $table->integer('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->integer('advert_id')->references('id')->on('adverts')->onDelete('CASCADE');
            $table->timestamps();
            $table->primary(['user_id', 'advert_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites_advert');
    }
};
