<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminExtensionsTable extends Migration
{
    public function getConnection()
    {
        return $this->config('database.connection') ?: config('database.default');
    }

    public function config($key)
    {
        return config('admin.'.$key);
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->config('database.extensions_table') ?: 'admin_extensions', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 100)->unique();
            $table->string('version', 20)->default('');
            $table->tinyInteger('is_enabled')->default(0);
            $table->text('options')->nullable();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        Schema::create($this->config('database.extension_histories_table') ?: 'admin_extension_histories', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('name', 100);
            $table->tinyInteger('type')->default(1);
            $table->string('version', 20)->default(0);
            $table->text('detail')->nullable();

            $table->index('name');
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->config('database.extensions_table') ?: 'admin_extensions');
        Schema::dropIfExists($this->config('database.extension_histories_table') ?: 'admin_extension_histories');
    }
}
