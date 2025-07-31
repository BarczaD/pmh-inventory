<?php

use yii\db\Migration;

class m250731_084917_add_registration_date_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $db = Yii::$app->db;
        $schema = $db->schema->getTableSchema("{{user}}");

        if (!isset($schema->columns['registration_date'])) {
            $this->addColumn("user", 'registration_date', $this->dateTime()->null()->after('username'));
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user', 'registration_date');

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250731_084917_add_registration_date_to_user_table cannot be reverted.\n";

        return false;
    }
    */
}
