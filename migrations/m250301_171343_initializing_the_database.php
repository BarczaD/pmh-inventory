<?php

use yii\db\Migration;

class m250301_171343_initializing_the_database extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'password' => $this->string()->notNull()
        ]);

        $this->createTable('colleague', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()
        ]);

        $this->createTable('monitor', [
            'id' => $this->primaryKey(),
            'brand' => $this->string()->notNull(),
            'aspect_ratio' => $this->string()->notNull(),
            'serial_number' => $this->string()->notNull()
        ]);

        $this->createTable('computer', [
            'id' => $this->primaryKey(),
            'colleague_id' => 'integer NOT NULL REFERENCES colleague(id)',
            'dns_name' => $this->string()->notNull(),
            'office' => $this->string()->notNull(),
            'cpu' => $this->string()->notNull(),
            'ram' => $this->string()->notNull(),
            'storage_type' => $this->string()->notNull(),
            'storage_capacity' => $this->string()->notNull(),
            'monitor_id1' => 'integer NOT NULL REFERENCES monitor(id)',
            'monitor_id2' => 'integer REFERENCES monitor(id)',
            'keyboard' => $this->string(),
            'mouse' => $this->string(),
            'office_license' => $this->string()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-computer-colleague_id',
            'computer'
        );

        $this->dropForeignKey(
            'fk-computer-colleague_id',
            'computer'
        );

        $this->dropForeignKey(
            'fk-computer-colleague_id',
            'computer'
        );

        $this->dropTable('monitor');
        $this->dropTable('colleague');
        $this->dropTable('computer');
        $this->dropTable('user');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250301_171343_initializing_the_database cannot be reverted.\n";

        return false;
    }
    */
}
