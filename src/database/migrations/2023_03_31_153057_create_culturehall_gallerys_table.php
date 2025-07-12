<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCulturehallGallerysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('culturehall_gallerys', function (Blueprint $table) {
            $table->id();
            $table->integer('culturehall_id')->comment('รหัส')->nullable(); 
            $table->string('image_desktop')->comment('รูปแสดงผลบน web site')->nullable();  
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
        Schema::dropIfExists('culturehall_gallerys');
    }
}
