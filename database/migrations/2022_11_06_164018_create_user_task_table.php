<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\UserTask;

class CreateUserTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_task', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(UserTask::COLUMN_USER_ID)->index();
            $table->unsignedBigInteger(UserTask::COLUMN_TASK_ID)->index();
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
        Schema::dropIfExists('user_task');
    }
}
