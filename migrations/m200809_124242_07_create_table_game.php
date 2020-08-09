<?php

use yii\db\Migration;

class m200809_124242_07_create_table_game extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%game}}',
            [
                'id' => $this->primaryKey(),
                'id_idea' => $this->integer(),
                'multiplayer' => $this->boolean()->notNull()->defaultValue('0'),
            ],
            $tableOptions
        );

        $this->createIndex('id_idea', '{{%game}}', ['id_idea']);

        $this->addForeignKey(
            'game_ibfk_1',
            '{{%game}}',
            ['id_idea'],
            '{{%idea}}',
            ['id'],
            'NO ACTION',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%game}}');
    }
}
