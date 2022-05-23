<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jabatans extends Migration
{
    private string $table ="jabatans";
    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `$this->table` (
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(15) NULL DEFAULT '',
            `description` LONGTEXT NULL DEFAULT '',
            PRIMARY KEY (`id`),
            INDEX `name` (`name`)
        )";

        $this->db->query( $sql );
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS `$this->table`";
        $this->db->query( $sql );
    }
}
