<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsHasTasksTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('accounts_has_tasks', function (Blueprint $table) {
            $table->unsignedSmallInteger('task_id');
            $table->string('account_id', 100);
            $table->longText('details');
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('account_id')->references('key')->on('accounts')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('task_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('accounts_has_tasks');
    }
}
