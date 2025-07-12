<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('networks', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('ชื่อ')->nullable();
            $table->string('intro')->comment('รายละเอียดย่อ')->nullable();
            $table->text('file_text')->comment('รายละเอียดหลัก')->nullable();
            $table->date('date')->comment('วันที่ลง')->nullable();
            $table->string('slug')->comment('ชื่อลิงค์')->nullable();
            $table->string('image_desktop')->comment('รูปแสดงผลบน web site')->nullable();
            $table->integer('status')->comment('0 = draft 1=public  2= no/off')->nullable();
            $table->string('file_pdf')->nullable();
            $table->integer('count_view')->nullable();

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
        Schema::dropIfExists('networks');
    }
}
