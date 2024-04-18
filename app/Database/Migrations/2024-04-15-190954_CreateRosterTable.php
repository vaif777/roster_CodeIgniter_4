<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRosterTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'small_business_entity_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'supervisory_authority_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'planned_verification_period_from' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'planned_verification_period_before' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'planned_duration_check' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('rosters');
    }

    public function down()
    {
        $this->forge->dropTable('rosters');
    }
}
