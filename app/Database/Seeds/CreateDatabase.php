<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CreateDatabase extends Seeder
{
    public function run()
    {
        $forge = \Config\Database::forge();
			
        if( $forge->createDatabase('absensi_karyawan',true)) {
            echo "Database absensi_karyawan has created";
        }else{
            echo "Gagal Dibuat ";
        }
    }
}
