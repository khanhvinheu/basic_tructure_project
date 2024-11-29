<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password_default=123456;
        $listTypeTask=[
            [
                "name"=>'admin',
                "chucvu"=>'dev',
                "donvicongtac"=>'dev',
                "phone_number"=>'0868350978',
                "note"=>'123',
                "email"=>'admin@gmail.com',
                "password"=>Hash::make($password_default),
                "id_module_default"=>'4',
                "role_code"=>'R0001',
                "privatekey"=> "MIGHAgEAMBMGByqGSM49AgEGCCqGSM49AwEHBG0wawIBAQQgnGHf01V7mPLDEkElyGime+TxAPMmtteS4K3NOLNNOvihRANCAAShEzP2jMzPvCe3LljfKzHUuVFg03o+DdSyFD8rbZkvaJRME1kmr3owq5HgmGJpmZosRGbvO/kEMPBKwDdWhe8h",
                "publickey"=>"MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEoRMz9ozMz7wnty5Y3ysx1LlRYNN6Pg3UshQ/K22ZL2iUTBNZJq96MKuR4JhiaZmaLERm7zv5BDDwSsA3VoXvIQ=="
            ] ,
            [
                "name"=>'user',
                "chucvu"=>'dev',
                "donvicongtac"=>'dev',
                "phone_number"=>'0868350978',
                "note"=>'123',
                "email"=>'user@gmail.com',
                "password"=>Hash::make($password_default),
                "id_module_default"=>'7',
                "role_code"=>'R0002',
                "privatekey"=> "MIGHAgEAMBMGByqGSM49AgEGCCqGSM49AwEHBG0wawIBAQQg4VYrE0UxZOydLils7u+MNBam3yAcvmV7Q10KBtqZGDmhRANCAAQba8+qWgpunT1fZirU/vP6Fwfemo7qRh8mwJVWxX5sQzMWwnkaf5cQX1a9nIz55mjXCrWMlwAWJFA8ipCEYEbz",
                "publickey"=>"MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEG2vPqloKbp09X2Yq1P7z+hcH3pqO6kYfJsCVVsV+bEMzFsJ5Gn+XEF9WvZyM+eZo1wq1jJcAFiRQPIqQhGBG8w=="
            ] ,
        ];
        foreach ($listTypeTask as $index =>$value){
            $data =$value;
            User::insert($data);
        }
        dump('Add data user success');
    }
}
