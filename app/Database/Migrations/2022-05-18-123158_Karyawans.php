<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Karyawans extends Migration
{
    private string $table = "karyawans";

    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `$this->table` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `user_id` INT(11) NULL DEFAULT NULL,
            `address` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
            `position` ENUM('CEO','CTO','CFO','CMO','COO','WPP') NULL DEFAULT 'CEO' COLLATE 'latin1_swedish_ci',
            `created_at` INT(11) NULL DEFAULT NULL,
            `updated_at` INT(11) NULL DEFAULT NULL,
            `no_hp` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
            `salary` INT(11) NULL DEFAULT NULL COMMENT 'per month',
            `photo` LONGTEXT NULL DEFAULT 'assets/images/avatar.png' COLLATE 'latin1_swedish_ci',
            PRIMARY KEY (`id`) USING BTREE,
            INDEX `address` (`address`) USING BTREE,
            INDEX `no_hp` (`no_hp`) USING BTREE
        )";

        $this->db->query( $sql );
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS `$this->table`";

        $this->db->query( $sql );
    }
}
