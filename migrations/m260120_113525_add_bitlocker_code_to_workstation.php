<?php

use yii\db\Migration;

class m260120_113525_add_bitlocker_code_to_workstation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $db = Yii::$app->db;
        $schema = $db->schema->getTableSchema("{{workstation}}");

        if (!isset($schema->columns['bitlocker_code'])) {
            $this->addColumn("{{workstation}}", 'bitlocker_code', $this->string()->defaultValue(""));
        }

        $this->update('workstation', ['bitlocker_code' => ""]);

        return true;

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('workstation', 'bitlocker_code');

        return true;
    }

}
