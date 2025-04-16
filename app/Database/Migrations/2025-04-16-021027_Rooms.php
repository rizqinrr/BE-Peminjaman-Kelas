<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rooms extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_room' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
                'null' => false,
            ],
            'room_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'location' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'capacity' => [
                'type' => 'CHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_room', true); //primary key
        $this->forge->createTable('rooms');
    }

    public function down()
    {
        $this->forge->dropTable('rooms');
    }
}
