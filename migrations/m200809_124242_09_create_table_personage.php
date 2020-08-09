<?php

use yii\db\Migration;

class m200809_124242_09_create_table_personage extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%personage}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
                'id_game' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->createIndex('id_game', '{{%personage}}', ['id_game']);

        $this->addForeignKey(
            'personage_ibfk_1',
            '{{%personage}}',
            ['id_game'],
            '{{%game}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%personage}}');
    }
}
