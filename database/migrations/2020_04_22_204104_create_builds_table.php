<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildsTable extends Migration
{
    public function up()
    {
        Schema::create('builds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('repository_id');

            $table->string('status');

            $table->timestamp('start_at');
            $table->timestamp('started_at')->nullable();
            $table->timestamps();
            $table->timestamp('finished_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('builds');
    }
}
