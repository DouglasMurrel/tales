<?php

use yii\db\Migration;

class m200809_124242_03_create_table_user extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%user}}',
            [
                'id' => $this->primaryKey(),
                'email' => $this->string(180)->notNull(),
                'roles' => $this->text()->notNull(),
                'password' => $this->string()->notNull(),
                'passwordHash' => $this->string(),
            ],
            $tableOptions
        );

        $this->createIndex('email', '{{%user}}', ['email'], true);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
