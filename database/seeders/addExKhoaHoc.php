<?php

namespace Database\Seeders;

use App\Models\admin\thongTinKhoaHocs;
use Illuminate\Database\Seeder;
use DB;
class addExKhoaHoc extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $listTypeTask=[
            [
                "maKhoaHoc"=>'KH0001',
                "tenKhoaHoc"=>'Công nghệ thông tin cơ bản',
                "tenKhoaHocEN"=>'Basic Information Technology',
                "chiTietKhoaHoc"=>'Kỹ năng tiếp cận công nghệ thông tin cơ bản',
                "thoiGianDaoTao"=>'90',
                "tuNgay"=>'01/03/2023',
                "denNgay"=>'31/05/2023',
                "noiDaoTao"=>'Trường Trung cấp nghề Tân Hiệp tỉnh Kiên Giang',
                "noiDaoTaoEN"=>'Tan Hiep Vocational Secondary School in Kien Giang Province',
            ],
            [
                "maKhoaHoc"=>'KH0002',
                "tenKhoaHoc"=>'Công nghệ thông tin cơ bản',
                "tenKhoaHocEN"=>'Basic Information Technology',
                "chiTietKhoaHoc"=>'Kỹ năng tiếp cận công nghệ thông tin cơ bản',
                "thoiGianDaoTao"=>'90',
                "tuNgay"=>'01/03/2023',
                "denNgay"=>'31/05/2023',
                "noiDaoTao"=>'Trường Trung cấp nghề Tân Hiệp tỉnh Kiên Giang',
                "noiDaoTaoEN"=>'Tan Hiep Vocational Secondary School in Kien Giang Province',
            ],
        ];
        // Disable foreign key checks to prevent issues during truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate the table
        DB::table('thongTinKhoaHocs')->truncate();

        // Enable foreign key checks again
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        foreach ($listTypeTask as $index =>$value){
            $data =$value;
            thongTinKhoaHocs::insert($data);
        }
        dump('Add list module success');
    }
}
