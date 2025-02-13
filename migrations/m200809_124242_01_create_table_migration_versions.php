<?php

use yii\db\Migration;

class m200809_124242_01_create_table_migration_versions extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '{{%migration_versions}}',
            [
                'version' => $this->string(14)->notNull()->append('PRIMARY KEY'),
                'executed_at' => $this->dateTime()->notNull()->comment('(DC2Type:datetime_immutable)'),
            ],
            $tableOptions
        );
    }

    public function down()
    {
        $this->dropTable('{{%migration_versions}}');
    }
}
