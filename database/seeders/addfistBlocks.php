<?php

namespace Database\Seeders;

use App\Models\admin\Blocks;
use Illuminate\Database\Seeder;
use DB;

class addfistBlocks extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $listTypeTask = [
            [
                "index" => 0,
                "timestamp" => '2024-10-17T09:59:28.388Z',
                "data" => '{"year":2024}',
                "previousHash" => '0',
                "signature" => '',
                "hash" => '40f5d3576ccfd220db9918d544af9b1a65c3d973c6de1ae082510f053bc23150'
            ]
        ];
        // Disable foreign key checks to prevent issues during truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate the table
        DB::table('blocks')->truncate();

        // Enable foreign key checks again
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        foreach ($listTypeTask as $index => $value) {
            $data = $value;
            Blocks::insert($data);
        }
        dump('Add list module success');
    }
}
