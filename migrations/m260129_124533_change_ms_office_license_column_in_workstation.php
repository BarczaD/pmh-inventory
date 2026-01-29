<?php

use yii\db\Migration;

class m260129_124533_change_ms_office_license_column_in_workstation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Changing the column type to varchar(255)
        // Adjust the table name if it is singular/plural in your DB (e.g., 'workstation' vs 'workstations')
        $this->alterColumn('{{%workstation}}', 'ms_office_license', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // This is tricky if you don't know the exact previous type.
        // Assuming it was an integer, you would revert it here:
        $this->alterColumn('{{%workstation}}', 'ms_office_license', $this->integer());

        echo "Warning: safeDown might fail if existing varchar data cannot be converted back to integer.\n";
    }
}
