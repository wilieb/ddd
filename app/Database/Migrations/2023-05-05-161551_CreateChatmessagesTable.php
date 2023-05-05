<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChatmessagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'chat_id' => [
                'type' => 'VARCHAR',
                'constraint' => '46',
                'null' => false,
            ],
            'sender_t' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'sender_n' => [
                'type' => 'VARCHAR',
                'constraint' => '55',
                'null' => true,
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'message' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey(['chat_id', 'sender_t', 'type', 'time']);
        $this->forge->createTable('chat_messages', true);
    }

    public function down()
    {
        $this->forge->dropTable('chat_messages', true);
    }
}
