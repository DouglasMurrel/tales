<?php

use yii\db\Migration;

class m200809_124242_05_create_table_idea extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%idea}}',
            [
                'id' => $this->primaryKey(),
                'id_user' => $this->integer(),
                'text' => $this->text(),
                'dt' => $this->dateTime(),
                'adult' => $this->boolean()->notNull()->defaultValue('0'),
                'multiplayer' => $this->boolean()->notNull()->defaultValue('0'),
                'vacant' => $this->boolean()->notNull()->defaultValue('1'),
            ],
            $tableOptions
        );

        $this->createIndex('id_user', '{{%idea}}', ['id_user']);

        $this->addForeignKey(
            'idea_ibfk_1',
            '{{%idea}}',
            ['id_user'],
            '{{%user}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%idea}}');
    }
}
