<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsDataTable extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('accounts_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key',100)->unique();
            $table->string('names',60);
            $table->string('first_name',60);
            $table->string('last_names',60);
            $table->string('birthdate')->date();
            $table->string('photo',100)->default('profile.png');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('accounts_data');
    }
}
