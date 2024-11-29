<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ThongTinKhoaHoc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('thongTinKhoaHocs', function (Blueprint $table) {
            $table->id();
            $table->string('maKhoaHoc')->unique();
            $table->string('tenKhoaHoc');
            $table->string('tenKhoaHocEN');
            $table->string('chiTietKhoaHoc');
            $table->string('thoiGianDaoTao');
            $table->string('tuNgay');
            $table->string('denNgay');
            $table->string('noiDaoTao');                         
            $table->string('noiDaoTaoEN');                         
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
        Schema::dropIfExists('thongTinKhoaHocs');
    }
}
