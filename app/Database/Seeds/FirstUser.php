<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class FirstUser extends Seeder
{
    public function run()
    {
      $this->insert();
    }

    private function insert()
    {
        $now      = Time::now('Asia/Jakarta','id')->getTimestamp();
        $db       = \Config\Database::connect();
        $password = sha1("admin");
        $data     = [
            'name'=>'ADMIN',
            'username' => 'admin',
            'password' => $password, 
            'status' => 'ADMIN',
            'created_at' => $now,
            'updated_at' => $now
        ];

        $db->transStart();
        $db->table('users')->insert( $data );
        $db->transComplete();

        if( $db->transStatus() === false ) {
            echo "Admin Gagal Dibuat";
        }else{
            echo "Admin Pertama sudah dibuat";
        }
    }
}
