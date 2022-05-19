<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Absens extends Migration
{
    private string $table = "absens";

    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `$this->table` (
            `id` INT(11) NOT NULL,
            `users_id` INT(11) NULL DEFAULT NULL,
            `created_at` INT(11) NULL DEFAULT NULL COMMENT 'use time stamp',
            `status` ENUM('MASUK','TANPA_KETERANGAN','CUTI','IZIN') NULL DEFAULT 'MASUK',
            `description` LONGTEXT NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            INDEX `status` (`status`)
        )";

        $this->db->query( $sql );
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS `$this->table`";

        $this->db->query( $sql );
    }
}
