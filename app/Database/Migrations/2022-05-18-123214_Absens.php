<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Absens extends Migration
{
    private string $table = "absens";

    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `$this->table` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `user_id` INT(11) NULL DEFAULT NULL,
            `status` ENUM('MASUK','TANPA_KETERANGAN','CUTI','IZIN') NULL DEFAULT 'MASUK' COLLATE 'latin1_swedish_ci',
            `description` LONGTEXT NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
            `created_at` INT(11) NULL DEFAULT NULL COMMENT 'use time stamp',
            `updated_at` INT(11) NULL DEFAULT NULL,
            PRIMARY KEY (`id`) USING BTREE,
            INDEX `status` (`status`) USING BTREE
        )";

        $this->db->query( $sql );
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS `$this->table`";

        $this->db->query( $sql );
    }
}
