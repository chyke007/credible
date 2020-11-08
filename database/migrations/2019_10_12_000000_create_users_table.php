<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('role_id')->index()->default(2);
            //$table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('referral_code')->unique();
            $table->string('email')->unique();
            $table->integer('wallet')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('identity')->default('');
            $table->string('accountNumber')->default('');
            $table->string('accountName')->default('');
            $table->string('bank')->default('');
            $table->dateTime('last_login')->nullable();
            $table->boolean('valid')->default(false);
            $table->rememberToken();
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
        //$table->dropForeign('user_roles_id_foreign');
        Schema::dropIfExists('users');
    }
}
