<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key', 100)->unique();
            $table->string('nickname', 50)->unique();
            $table->string('num_employer', 20)->unique();
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->unsignedSmallInteger('status_id');
            $table->string('data_id', 100);
            $table->unsignedSmallInteger('rol_id');
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('accounts_status')->onDelete('cascade');
            $table->foreign('data_id')->references('key')->on('accounts_data')->onDelete('cascade');
            $table->foreign('rol_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('accounts');
    }
}
