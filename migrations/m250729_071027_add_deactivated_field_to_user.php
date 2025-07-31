<?php

use yii\db\Migration;

class m250729_071027_add_deactivated_field_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $db = Yii::$app->db;


        $schema = $db->schema->getTableSchema("{{user}}");

        if (!isset($schema->columns['deactivated'])) {
            $this->addColumn("{{user}}", 'deactivated', $this->boolean()->notNull()->defaultValue(0));
        }

        $this->update('user', ['deactivated' => 0]);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'deactivated');
    }
}


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250729_071027_add_deactivated_field_to_user cannot be reverted.\n";

        return false;
    }
    */

