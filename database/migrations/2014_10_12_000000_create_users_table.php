<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('f_name')->nullable();
            $table->string('email')->unique();
            $table->string('gender')->nullable();
            $table->string('number')->nullable();
            $table->string('cnic')->nullable();
            $table->string('address')->nullable();
            $table->string('role')->nullable();
            $table->string('assign_modular_grp')->nullable();
            $table->string('type')->nullable();
            $table->string('password');
            $table->string('confirm_password')->nullable();
            $table->integer('login_status')->default(1);
            $table->string('employee_status')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('company_id')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('browser_info')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
