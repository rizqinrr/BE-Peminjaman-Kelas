<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
                'null' => false,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '50', 
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100', 
                'null' => false,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
            ],
            'role' => [
                'type'       => 'TEXT',
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
        $this->forge->addKey('id_user', true); //primary key
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
