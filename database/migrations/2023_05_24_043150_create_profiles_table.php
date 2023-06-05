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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->string('surname')->nullable();
            $table->string('image_url')->default(env("APP_URL") . "storage/images/profiles/default.png");
            $table->text('about_me')->nullable();
            $table->string('city')->nullable();
            $table->date('date_of_birthday')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();

            $table->foreign('course_id')
                ->references('id')
                ->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
