<?php

namespace Database\Seeders;

use App\Models\admin\danhSachCapChungChiHocViens;
use Illuminate\Database\Seeder;
use DB;

class addExDanhSachCap extends Seeder
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
                "maChungChi"=>'000001',
                "hoTen"=>'Nguyễn Văn A',
                "namSinh"=>'01/01/1999',
                "gioiTinh"=>'Nam',
                "vanHoa"=>'12/12',
                "danToc"=>'Kinh',
                "queQuan"=>'Tân Hiệp - Kiên Giang',
                "diemTrungBinh"=>'3.0',
                "xepLoai"=>'Khá',
                "maDotCap"=>'DC0001',
                "maKhoaHoc"=>'KH0001',
            ],
            [
                "maChungChi"=>'000002',
                "hoTen"=>'Nguyễn Văn B',
                "namSinh"=>'01/01/2000',
                "gioiTinh"=>'Nam',
                "vanHoa"=>'12/12',
                "danToc"=>'Kinh',
                "queQuan"=>'Tân Hiệp - Kiên Giang',
                "diemTrungBinh"=>'4.0',
                "xepLoai"=>'Xuất sắc',
                "maDotCap"=>'DC0002',
                "maKhoaHoc"=>'KH0002',
            ],
        ];
        // Disable foreign key checks to prevent issues during truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate the table
        DB::table('danhSachCapChungChiHocViens')->truncate();

        // Enable foreign key checks again
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        foreach ($listTypeTask as $index =>$value){
            $data =$value;
            danhSachCapChungChiHocViens::insert($data);
        }
        dump('Add list module success');
    }
}
