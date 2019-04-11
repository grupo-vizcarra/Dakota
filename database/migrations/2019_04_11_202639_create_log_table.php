<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_id',100);
            $table->unsignedSmallInteger('type_log_id');
            $table->timestamps();

            $table->foreign('account_id')->references('key')->on('accounts')->onDelete('cascade');
            $table->foreign('type_log_id')->references('id')->on('type_log')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('log');
    }
}
