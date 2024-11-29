<?php

namespace Database\Seeders;

use App\Models\admin\dotCaps;
use Illuminate\Database\Seeder;
use DB;

class addExDotCap extends Seeder
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
                "maDot"=>'DC0001',
                "thoiGianCap"=>'Ngày 26/03/2023',
                "ghiChu"=>'Cấp văn bằng CNTT cơ bản',
            ],
            [
                "maDot"=>'DC0002',
                "thoiGianCap"=>'Ngày 26/04/2023',
                "ghiChu"=>'Cấp văn bằng CNTT nâng cao',
            ],
        ];
        // Disable foreign key checks to prevent issues during truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate the table
        DB::table('dotCaps')->truncate();

        // Enable foreign key checks again
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        foreach ($listTypeTask as $index =>$value){
            $data =$value;
            dotCaps::insert($data);
        }
        dump('Add list module success');
    }
}
