<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsHasPermissions extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('accounts_has_permissions', function (Blueprint $table){
            $table->string('account_id', 100);
            $table->unsignedSmallInteger('permission_id');
            $table->timestamps();
            $table->foreign('account_id')->references('key')->on('accounts')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('accounts_has_permissions');
    }
}
