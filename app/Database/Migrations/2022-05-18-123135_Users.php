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
            `id` INT(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(20) NULL DEFAULT '0' COLLATE 'latin1_swedish_ci',
            `updated_at` INT(15) NULL DEFAULT '0',
            `created_at` INT(15) NULL DEFAULT '0',
            `username` VARCHAR(20) NULL DEFAULT '0' COLLATE 'latin1_swedish_ci',
            `password` VARCHAR(50) NULL DEFAULT '0' COLLATE 'latin1_swedish_ci',
            `role` ENUM('ADMIN','KARYAWAN') NULL DEFAULT 'KARYAWAN' COLLATE 'latin1_swedish_ci',
            PRIMARY KEY (`id`) USING BTREE,
            INDEX `name` (`name`) USING BTREE,
            INDEX `status` (`role`) USING BTREE
        )";

        $this->db->query( $sql );
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXIST `$this->table`";
        
        $this->db->query( $sql );
    }
}
