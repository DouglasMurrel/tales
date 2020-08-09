<?php

use yii\db\Migration;

class m200809_124242_06_create_table_tag_idea_rel extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%tag_idea_rel}}',
            [
                'id_tag' => $this->integer()->notNull(),
                'id_idea' => $this->integer()->notNull(),
            ],
            $tableOptions
        );

        $this->addPrimaryKey('PRIMARYKEY', '{{%tag_idea_rel}}', ['id_tag', 'id_idea']);

        $this->createIndex('id_idea', '{{%tag_idea_rel}}', ['id_idea']);

        $this->addForeignKey(
            'tag_idea_rel_ibfk_1',
            '{{%tag_idea_rel}}',
            ['id_tag'],
            '{{%tag}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'tag_idea_rel_ibfk_2',
            '{{%tag_idea_rel}}',
            ['id_idea'],
            '{{%idea}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%tag_idea_rel}}');
    }
}
