<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use App\Models\UsersModel;
use App\Controllers\Karyawans;

class FirstUser extends Seeder
{
    public function run()
    {
      $this->insert();
    }

    private function insert()
    {
        $UsersModel = new UsersModel();
        $now      = Time::now('Asia/Jakarta','id')->getTimestamp();
        // $db       = \Config\Database::connect();
        $password = sha1("admin");
        $data     = [
            'name'=>'ADMIN',
            'username' => 'admin',
            'password' => $password, 
            'role' => 'ADMIN',
            'created_at' => $now,
            'updated_at' => $now
        ];

        $UsersModel->transStart();
            $UsersModel->table('users')->insert( $data );
            $id = $UsersModel->getInsertID();
            
            $Karyawans = new Karyawans();
            $Karyawans->addTemp( $id );
        $UsersModel->transComplete();

        if( $UsersModel->transStatus() === false ) {
            echo "Admin Gagal Dibuat";
        }else{
            echo "Admin Pertama sudah dibuat";
        }
    }
}
