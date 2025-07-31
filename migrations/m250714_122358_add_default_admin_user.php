<?php

use yii\db\Migration;

class m250714_122358_add_default_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250714_122358_add_default_admin_user cannot be reverted.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250714_122358_add_default_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
