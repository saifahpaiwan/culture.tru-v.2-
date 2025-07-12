<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatedSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('related_sites', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('ชื่อเว็บไซต์ที่เกี่ยวข้อง')->nullable();   
            $table->string('slug')->comment('ชื่อลิงค์')->nullable();  
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
        Schema::dropIfExists('related_sites');
    }
}
