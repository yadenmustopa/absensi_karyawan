<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{

    private string $table = "users";

    public function up()
    {
        //
        $sql = "CREATE TABLE IF NOT EXISTS `$this->table`(
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `nama` VARCHAR(20) NULL DEFAULT '0',
            `username` VARCHAR(20) NULL DEFAULT '0',
            `password` VARCHAR(50) NULL DEFAULT '0',
            `status` ENUM('ADMIN','KARYAWAN') NULL DEFAULT 'KARYAWAN',
            PRIMARY KEY (`id`),
            INDEX `nama` (`nama`),
            INDEX `status` (`status`)
        )";

        $this->db->query( $sql );
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXIST `$this->table`";
        
        $this->db->query( $sql );
    }
}
