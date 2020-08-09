<?php

use yii\db\Migration;

class m200809_124242_08_create_table_game_user_rel extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%game_user_rel}}',
            [
                'id_user' => $this->integer()->notNull(),
                'id_game' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->addPrimaryKey('PRIMARYKEY', '{{%game_user_rel}}', ['id_user', 'id_game']);

        $this->createIndex('id_game', '{{%game_user_rel}}', ['id_game']);
        $this->createIndex('id_user', '{{%game_user_rel}}', ['id_user']);

        $this->addForeignKey(
            'game_user_rel_ibfk_1',
            '{{%game_user_rel}}',
            ['id_user'],
            '{{%user}}',
            ['id'],
            'NO ACTION',
            'CASCADE'
        );
        $this->addForeignKey(
            'game_user_rel_ibfk_2',
            '{{%game_user_rel}}',
            ['id_game'],
            '{{%game}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%game_user_rel}}');
    }
}
