<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DanhSachCapChungChiHocVien extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('danhSachCapChungChiHocViens', function (Blueprint $table) {
            $table->id();
            $table->string('maChungChi')->unique();
            $table->string('hoTen');
            $table->string('namSinh');
            $table->string('gioiTinh');
            $table->string('vanHoa');
            $table->string('danToc');
            $table->string('queQuan');
            $table->string('diemTrungBinh');
            $table->string('xepLoai');
            $table->string('image')->nullable();
            $table->string('ghiChu')->nullable();
            $table->string('maDotCap')->nullable();
            $table->foreign('maDotCap')->references('maDot')->on('dotCaps');  
            $table->string('maKhoaHoc')->nullable();
            $table->foreign('maKhoaHoc')->references('maKhoaHoc')->on('thongTinKhoaHocs');  
            $table->string('maHoSoKyDuyet')->nullable();
            $table->foreign('maHoSoKyDuyet')->references('maHoSo')->on('hoSoKyDuyets');  
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
        Schema::dropIfExists('danhSachCapChungChiHocViens');
    }
}
