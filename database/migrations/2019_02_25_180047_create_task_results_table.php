<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('task_id');
            $table->foreign('task_id')
                ->references('task_id')
                ->on('tasks');
            $table->boolean('ended')->default(false);
            $table->dateTime('date_time');
            $table->string('position')->nullable();
            $table->string('url', 400)->nullable();
            $table->string('title', 700)->nullable();
            $table->string('snippet_extra', 1500)->nullable();
            $table->string('snippet', 2500)->nullable();
            $table->bigInteger('count')->default(0);
            $table->string('extra')->nullable();
            $table->string('se_check_url', 900);
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
        Schema::dropIfExists('task_results');
    }
}
