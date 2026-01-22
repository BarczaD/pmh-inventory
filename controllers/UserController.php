<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\db\QueryInterface;
use yii\web\Controller;

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

    public static function changeUserState($id)
    {
        $user = User::findIdentity($id);
        $user->changeUserState();
        return true;
    }
}