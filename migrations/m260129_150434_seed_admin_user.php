<?php

use yii\db\Migration;

class m260129_150434_seed_admin_user extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'username' => 'admin',
            // Matches the 'password' column in your photo
            'password' => Yii::$app->security->generatePasswordHash('admin'),
            // Matches 'registration_date' (DATETIME format)
            'registration_date' => date('Y-m-d H:i:s'),
            // Matches 'auth_key'
            'auth_key' => Yii::$app->security->generateRandomString(),
            // Matches 'access_token'
            'access_token' => Yii::$app->security->generateRandomString(),
            // Matches 'deactivated' (0 = active)
            'deactivated' => 0,
        ]);
    }

    public function safeDown()
    {
        $this->delete('{{%user}}', ['username' => 'admin']);
    }
}