<?php

use yii\db\Migration;

class m200809_124242_02_create_table_tag extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%tag}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('name', '{{%tag}}', ['name'], true);
    }

    public function down()
    {
        $this->dropTable('{{%tag}}');
    }
}
