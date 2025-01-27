<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableClient extends Migration
{
  public function up()
  {
    $this->forge->addField([
      'id' => [
        'type' => 'INT',
        'constraint' => 5,
        'unsigned' => true,
        'auto_increment' => true,
      ],
      'name' => [
        'type' => 'VARCHAR',
        'constraint' => '100',
        'null' => false,
      ],
      'email' => [
        'type' => 'VARCHAR',
        'constraint' => '100',
        'null' => false,
        'unique' => true,
      ],
      'retainer_fee' => [
        'type' => 'INT',
        'constraint' => 100,
        'null' => false,
        'unique' => true,
      ],
      'updated_at' => [
        'type' => 'DATETIME',
        'null' => true,
      ],
      // es importante que el campo created_at se vea de esta forma
      'created_at datetime default current_timestamp',
    ]);
    $this->forge->addPrimaryKey('id');
    $this->forge->createTable('client');
  }
  
  public function down()
  {
    $this->forge->dropTable('client');
  }
}
