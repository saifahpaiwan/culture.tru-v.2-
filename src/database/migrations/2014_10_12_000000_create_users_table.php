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
            $table->id()->comment('รหัสผู้ใช้งาน');
            $table->string('name')->comment('ชื่อผู้ใช้งาน');  
            $table->string('email')->unique()->comment('อีเมล์ผู้ใช้งาน');  
            $table->string('password')->comment('รหัสผ่านผู้ใช้งาน');   
            $table->timestamp('email_verified_at')->nullable(); 
            $table->rememberToken(); 
            $table->char('roles', 1)->default(1)->nullable()->comment('สิทธ์การใช้งาน 1 = Administrator  2 = Editor');  

            $table->ipAddress('ip_address');
            $table->timestamps();
            $table->char('deleted_at', 1)->default(0); 
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
