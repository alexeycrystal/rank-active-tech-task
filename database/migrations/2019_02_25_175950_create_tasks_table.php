<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('task_identifier');
            $table->bigInteger('task_id')
                ->nullable(false)
                ->unique();
            $table->string('post_id');
            $table->string('post_key');
            $table->string('post_site');
            $table->bigInteger('se_id');
            $table->bigInteger('loc_id');
            $table->bigInteger('key_id');
            $table->boolean('status')
                ->default(false);
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
        Schema::dropIfExists('tasks');
    }
}
