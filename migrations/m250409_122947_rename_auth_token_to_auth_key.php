<?php

use yii\db\Migration;

class m250409_122947_rename_auth_token_to_auth_key extends Migration
{
    public function safeUp()
    {
        $this->renameColumn('{{%user}}', 'auth_token', 'auth_key');
    }

    public function safeDown()
    {
        $this->renameColumn('{{%user}}', 'auth_key', 'auth_token');
    }
}
