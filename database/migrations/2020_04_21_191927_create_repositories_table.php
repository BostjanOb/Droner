<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepositoriesTable extends Migration
{
    public function up()
    {
        Schema::create('repositories', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('name');
            $table->string('drone_slug');
            $table->string('git_link');

            $table->boolean('active')->default(false);
            $table->string('token', 64)->nullable();
            $table->unsignedInteger('threshold')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('repositories');
    }
}
