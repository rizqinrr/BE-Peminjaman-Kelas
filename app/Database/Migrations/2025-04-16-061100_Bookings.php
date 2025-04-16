<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bookings extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_booking' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'auto_increment' => true,
                'null' => false,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'id_room' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'booking_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'start_date' => [
                'type'       => 'DATE',
                'null' => false,
            ],
            'end_date' => [
                'type'       => 'DATE',
                'null' => false,
            ],
            'start_time' => [
                'type'       => 'TIME',
                'null' => false,
            ],
            'end_time' => [
                'type'       => 'TIME',
                'null' => false,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '250',
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM("Accepted", "Declined", "Pending", "Finished")',
                'default' => 'Pending',
            ],
            'created_at' => [
                'type'      => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_booking', true); //primary key
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE'); // foreign key
        $this->forge->addForeignKey('id_room', 'rooms', 'id_room', 'CASCADE', 'CASCADE'); // foreign key
        $this->forge->createTable('bookings');
    }

    public function down()
    {
        $this->forge->dropTable('bookings');
    }
}
