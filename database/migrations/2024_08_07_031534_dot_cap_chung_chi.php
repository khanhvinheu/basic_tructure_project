<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DotCapChungChi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('dotCaps', function (Blueprint $table) {
            $table->id();
            $table->string('maDot')->unique();
            $table->string('thoiGianCap');               
            $table->string('ghiChu');               
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
        Schema::dropIfExists('dotCaps');

    }
}
