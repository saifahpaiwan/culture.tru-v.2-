<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('page_title')->comment('ชื่อ')->nullable();    
            $table->string('page_intro')->comment('รายละเอียดย่อ')->nullable();
            $table->text('page_file_text')->comment('รายละเอียดหลัก')->nullable();
            $table->date('page_date')->comment('วันที่ลง')->nullable();
            $table->string('page_slug')->comment('ชื่อลิงค์')->nullable(); 
            $table->string('page_image_desktop')->comment('รูปแสดงผลบน web site')->nullable();   
            $table->integer('page_status')->comment('0 = draft 1=public  2= no/off')->nullable();   
            $table->string('file_pdf')->nullable(); 
            
            $table->string('page_meta_title')->nullable();  
            $table->text('page_meta_description')->nullable();  
            $table->text('page_meta_keyword')->nullable();  

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
        Schema::dropIfExists('pages');
    }
}
