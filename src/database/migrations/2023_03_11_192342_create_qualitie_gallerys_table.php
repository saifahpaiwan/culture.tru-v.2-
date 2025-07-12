<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualitieGallerysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qualitie_gallerys', function (Blueprint $table) {
            $table->id();
            $table->integer('qualitie_id')->comment('รหัส')->nullable(); 
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
        Schema::dropIfExists('qualitie_gallerys');
    }
}
