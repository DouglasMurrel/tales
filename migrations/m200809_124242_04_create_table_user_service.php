<?php

use yii\db\Migration;

class m200809_124242_04_create_table_user_service extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%user_service}}',
            [
                'id_user' => $this->integer()->notNull(),
                'id_service_user' => $this->string()->notNull(),
                'service' => $this->string(),
            ],
            $tableOptions
        );

        $this->createIndex('id_user', '{{%user_service}}', ['id_user', 'service'], true);
        $this->createIndex('id_service_user', '{{%user_service}}', ['id_service_user', 'service'], true);

        $this->addForeignKey(
            'user',
            '{{%user_service}}',
            ['id_user'],
            '{{%user}}',
            ['id'],
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%user_service}}');
    }
}
