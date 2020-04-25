<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepositoryUserTable extends Migration
{
    public function up()
    {
        Schema::create('repository_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('repository_id');

            $table->primary(['user_id', 'repository_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('repository_id')
                ->references('id')
                ->on('repositories');
        });
    }

    public function down()
    {
        Schema::dropIfExists('repository_user');
    }
}
