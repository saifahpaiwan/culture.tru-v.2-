<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('หัวข้อ')->nullable();    
            $table->string('description')->comment('คำอธิบาย')->nullable();
            $table->text('file_text')->comment('ไฟล์ .text')->nullable();
            $table->text('image_desktop')->comment('รูปแสดงผลบน web site')->nullable();
            $table->string('file_pdf')->comment('ไฟล์ .pdf')->nullable();
            
            $table->string('meta_title')->nullable();  
            $table->text('meta_description')->nullable();  
            $table->text('meta_keyword')->nullable();  
            
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
        Schema::dropIfExists('contacts');
    }
}
