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
}