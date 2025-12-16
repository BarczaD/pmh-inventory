<?php

use app\models\User;
use yii\db\Migration;

class m250714_122358_add_default_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = $this->getDb()->beginTransaction();
        try {
            $user = new User();
            $user->username = 'admin';
            $user->password = 'admin';
            $user->signup();
        } catch (\yii\db\Exception $e) {
            $transaction->rollBack();
            echo $e->getMessage();
        }
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
