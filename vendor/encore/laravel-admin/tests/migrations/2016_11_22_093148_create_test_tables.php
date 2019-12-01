<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTestTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image1');
            $table->string('image2');
            $table->string('image3');
            $table->string('image4');
            $table->string('image5');
            $table->string('image6');
            $table->timestamps();
        });

        Schema::create('test_multiple_images', function (Blueprint $table) {
            $table->increments('id');
            $table->text('pictures');
            $table->timestamps();
        });

        Schema::create('test_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('file1');
            $table->string('file2');
            $table->string('file3');
            $table->string('file4');
            $table->string('file5');
            $table->string('file6');
            $table->timestamps();
        });

        Schema::create('test_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('email');
            $table->string('mobile')->nullable();
            $table->string('avatar')->nullable();
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('test_user_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('postcode')->nullable();
            $table->string('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('color')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();

            $table->timestamps();
        });

        Schema::create('test_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('test_user_tags', function (Blueprint $table) {
            $table->integer('user_id');
            $table->integer('tag_id');
            $table->index(['user_id', 'tag_id']);
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
        Schema::dropIfExists('test_images');
        Schema::dropIfExists('test_multiple_images');
        Schema::dropIfExists('test_files');
        Schema::dropIfExists('test_users');
        Schema::dropIfExists('test_user_profiles');
        Schema::dropIfExists('test_tags');
        Schema::dropIfExists('test_user_tags');
    }
}
