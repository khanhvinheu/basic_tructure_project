<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HoSoKyDuyet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('hoSoKyDuyets', function (Blueprint $table) {
            $table->id();
            $table->string('maHoSo')->unique();
            $table->unsignedBigInteger('nguoiKyDuyet')->nullable();
            $table->foreign('nguoiKyDuyet')->references('id')->on('users');        
            $table->string('soChungChi')->nullable();
            $table->string('soVaoSo')->nullable();
            $table->string('thongTinLuu')->nullable();
            $table->string('publickey')->nullable();
            $table->string('privatekey')->nullable();
            $table->string('signature')->nullable();
            $table->string('hinhanhchuky')->nullable();
            $table->string('ghiChu')->nullable();             
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
        //
        Schema::dropIfExists('hoSoKyDuyets');
    }
}
