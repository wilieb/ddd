<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChatlogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => '36',
                'unique' => true,
            ],
            'user_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'page_id' => [
                'type' => 'VARCHAR',
                'constraint' => '36',
                'null' => true,
            ],
            'visitor_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'visitor_id' => [
                'type' => 'VARCHAR',
                'constraint' => '55',
                'null' => true,
            ],
            'visitor_email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'location_countryCode' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'location_city' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'message_count' => [
                'type' => 'INT',
                'default' => 0,
                'null' => true,
            ],
            'chat_duration' => [
                'type' => 'INT',
                'default' => 0,
                'null' => true,
            ],
            'rating' => [
                'type' => 'INT',
                'default' => 0,
                'null' => true,
            ],
            'created_on' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'domain' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
        ]);
        $this->forge->addPrimaryKey(['visitor_id','created_on', 'page_id']);
        $this->forge->createTable('chat_logs', true);
    }

    public function down()
    {
        $this->forge->dropTable('chat_logs', true);
    }
}
