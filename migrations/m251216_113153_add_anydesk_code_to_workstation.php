<?php

use yii\db\Migration;

class m251216_113153_add_anydesk_code_to_workstation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $db = Yii::$app->db;
        $schema = $db->schema->getTableSchema("{{workstation}}");

        if (!isset($schema->columns['anydesk_code'])) {
            $this->addColumn("{{workstation}}", 'anydesk_code', $this->string()->defaultValue(""));
        }

        $this->update('workstation', ['anydesk_code' => ""]);

        return true;

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('workstation', 'anydesk_code');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251216_113153_add_anydesk_code_to_workstation cannot be reverted.\n";

        return false;
    }
    */
}
