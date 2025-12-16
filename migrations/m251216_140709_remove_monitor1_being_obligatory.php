<?php

use yii\db\Migration;

class m251216_140709_remove_monitor1_being_obligatory extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // 1. Alter the column to allow NULL values.
        // The foreign key constraint already allows SET NULL, but the column itself must be nullable.
        $this->alterColumn('workstation', 'monitor_id1', $this->integer()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // 1. Revert the column back to NOT NULL (obligatory).
        // WARNING: This will fail if there are existing NULL values in the column.
        $this->alterColumn('workstation', 'monitor_id1', $this->integer()->notNull());
    }
}
