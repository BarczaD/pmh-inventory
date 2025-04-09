<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 *
 *
 * @property-read User|null $user
 */

class SignupForm extends Model
{
    public $username;
    public $password;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
        ];
    }

    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->password = $this->password;
            return $user->signup();
        }

        return false;
    }
}