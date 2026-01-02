<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{


    public function rules()
    {
        return [
            [['username', 'password', 'auth_key', 'access_token'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }


    /**
     * Signs the user up, registering them in the database
     * @return bool
     */
    public function signup()
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);

            $this->auth_key = Yii::$app->security->generateRandomString();
            $this->access_token = Yii::$app->security->generateRandomString();

            date_default_timezone_set('Europe/Budapest');
            $this->registration_date = date("Y-m-d h:i:s");

            if (!$this->save(false)) {
                throw new \Exception('Nem sikerült létrehozni a felhasználót.');
            }

            $transaction->commit();
            return true;

        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Regisztráció sikertelen: " . $e->getMessage(), __METHOD__);

            return false;
        }
    }

    public static function getAllUsers()
    {
        return static::find()->with();
    }

    public function changeDeactivationState()
    {
        $this->deactivated = !$this->deactivated;
    }

    public static function deactivateUser($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = self::findOne($id);
            $user->changeDeactivationState();
            if ($user->save()) {
                $transaction->commit();
                return true;
            }
            return false;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }

    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->isNewRecord) {
            return parent::save($runValidation, $attributeNames);
        }

        if ($runValidation && !$this->validate($attributeNames)) {
            return false;
        }

        return (bool)$this->updateAttributes($this->getDirtyAttributes($attributeNames));
    }

}
