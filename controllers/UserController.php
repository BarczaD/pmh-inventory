<?php

namespace app\controllers;

use app\models\User;
use yii\base\Controller;

class UserController extends Controller
{
    public static function getUser($id)
    {
        return User::findIdentity($id);
    }

    public static function getAllUsers()
    {
        return User::getAllUsers();
    }

    public static function deactivateUser($id)
    {
        $user = User::findIdentity($id);
    }
}